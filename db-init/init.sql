-- Create the user table
CREATE TABLE "user" (
    id serial4 NOT NULL,
    username varchar(50) NOT NULL,
    "password" varchar(255) NOT NULL,
    email varchar(100) NOT NULL,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    is_active int2 NOT NULL DEFAULT 1,
    CONSTRAINT user_email_key UNIQUE (email),
    CONSTRAINT user_pkey PRIMARY KEY (id),
    CONSTRAINT user_username_key UNIQUE (username)
);

CREATE TABLE "user_tokens" (
    user_id int4 NOT NULL,
    "token" varchar(64) NOT NULL,
    expiry int4 NOT NULL,
    CONSTRAINT user_tokens_pkey PRIMARY KEY (user_id),
    CONSTRAINT user_tokens_user_id_fkey FOREIGN KEY (user_id) REFERENCES "user"(id) ON DELETE CASCADE
);

-- Create the role table
CREATE TABLE "role" (
    id serial4 NOT NULL,
    role_name varchar(50) NOT NULL,
    CONSTRAINT role_pkey PRIMARY KEY (id),
    CONSTRAINT role_role_name_key UNIQUE (role_name)
);

-- Create the user_role table (many-to-many relationship)
CREATE TABLE "user_role" (
    user_id int4 NOT NULL,
    role_id int4 NOT NULL,
    CONSTRAINT user_role_pkey PRIMARY KEY (user_id, role_id),
    CONSTRAINT user_role_role_id_fkey FOREIGN KEY (role_id) REFERENCES "role"(id) ON DELETE CASCADE,
    CONSTRAINT user_role_user_id_fkey FOREIGN KEY (user_id) REFERENCES "user"(id) ON DELETE CASCADE
);

-- Create the car table
CREATE TABLE "car" (
    id serial4 NOT NULL,
    make varchar(50) NOT NULL,
    model varchar(50) NOT NULL,
    "year" int4 NOT NULL,
    is_available bool NULL DEFAULT true,
    CONSTRAINT car_pkey PRIMARY KEY (id)
);

CREATE TABLE "car_pricing" (
    id serial4 NOT NULL,
    car_id int4 NULL,
    hour_price float4 NOT NULL,
    CONSTRAINT car_pricing_pkey PRIMARY KEY (id),
    CONSTRAINT car_pricing_car_id_fkey FOREIGN KEY (car_id) REFERENCES car(id) ON DELETE CASCADE
);

CREATE TABLE "car_spec" (
    id serial4 NOT NULL,
    car_id int4 NULL,
    power int4 NOT NULL,
    color varchar(50) NOT NULL,
    CONSTRAINT car_spec_pkey PRIMARY KEY (id),
    CONSTRAINT car_spec_car_id_fkey FOREIGN KEY (car_id) REFERENCES car(id) ON DELETE CASCADE
);

CREATE TABLE "car_photo" (
    id serial4 NOT NULL,
    car_id int4 NULL,
    photo_name varchar(255) NOT NULL,
    CONSTRAINT car_photo_pkey PRIMARY KEY (id),
    CONSTRAINT car_photo_car_id_fkey FOREIGN KEY (car_id) REFERENCES car(id) ON DELETE CASCADE
);

-- Create the reservation table (one-to-many relationship with Users and Cars)
CREATE TABLE "reservation" (
    id serial4 NOT NULL,
    user_id int4 NULL,
    car_id int4 NULL,
    reservation_date timestamp NOT NULL,
    return_date timestamp NOT NULL,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT reservation_pkey PRIMARY KEY (id),
    CONSTRAINT reservation_car_id_fkey FOREIGN KEY (car_id) REFERENCES car(id) ON DELETE CASCADE,
    CONSTRAINT reservation_user_id_fkey FOREIGN KEY (user_id) REFERENCES "user"(id) ON DELETE CASCADE
);

-- Create the payment_details table (one-to-one relationship with Reservations)
CREATE TABLE "payment_details" (
    id serial4 NOT NULL,
    reservation_id int4 NULL,
    amount numeric(10, 2) NOT NULL,
    payment_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    payment_method varchar(50) NOT NULL,
    CONSTRAINT payment_details_pkey PRIMARY KEY (id),
    CONSTRAINT payment_details_reservation_id_key UNIQUE (reservation_id),
    CONSTRAINT payment_details_reservation_id_fkey FOREIGN KEY (reservation_id) REFERENCES reservation(id) ON DELETE CASCADE
);

-- Insert initial roles
INSERT INTO "role" (role_name) VALUES ('admin'), ('customer');

-- Insert default admin user, default pass - admin123
INSERT INTO "user" (username, password, email) VALUES ('admin', '$2y$10$HS4yJbBKmryUqXYMjVmCJOY2ErCxOapOj8tsf3HwKcYk89XVBZpni', 'admin@example.com');
INSERT INTO "user_role" (user_id, role_id) VALUES (1, 1);

-- Insert initial car data
INSERT INTO "car" (make, model, year, is_available) VALUES ('Maker1', 'Model1', 2021, TRUE);
INSERT INTO "car" (make, model, year, is_available) VALUES ('Maker2', 'Model4', 2019, TRUE);
INSERT INTO "car" (make, model, year, is_available) VALUES ('Maker1', 'Model2', 2024, TRUE);
INSERT INTO "car" (make, model, year, is_available) VALUES ('Maker3', 'Model1', 2023, TRUE);

-- Insert initial car specs
INSERT INTO "car_spec" (car_id, power, color) VALUES (1, 200, 'blue');
INSERT INTO "car_spec" (car_id, power, color) VALUES (2, 144, 'red');
INSERT INTO "car_spec" (car_id, power, color) VALUES (3, 315, 'black');
INSERT INTO "car_spec" (car_id, power, color) VALUES (4, 400, 'brown');

-- Insert initial car price
INSERT INTO "car_pricing" (car_id, hour_price) VALUES (1, 4.00);
INSERT INTO "car_pricing" (car_id, hour_price) VALUES (2, 2.00);
INSERT INTO "car_pricing" (car_id, hour_price) VALUES (3, 6.50);
INSERT INTO "car_pricing" (car_id, hour_price) VALUES (4, 3.00);

-- Create a view for user reservations
CREATE VIEW "user_reservation" AS
SELECT u.username, u.email, r.reservation_date,r.return_date, c.make, c.model, c.year
FROM "user" u
    JOIN "reservation" r ON u.id = r.user_id
    JOIN "car" c ON r.car_id = c.id;

-- Create a view for user details
CREATE VIEW "user_details" AS
SELECT u.id AS user_id, u.username, u.email, u.created_at, u.is_active, r.role_name, t.token, t.expiry
FROM "user" u
    LEFT JOIN "user_role" ur ON u.id = ur.user_id
    LEFT JOIN "role" r ON ur.role_id = r.id
    LEFT JOIN "user_tokens" t ON u.id = t.user_id;

-- Create a function to calculate total revenue
CREATE FUNCTION calculate_total_revenue() RETURNS DECIMAL(10, 2) AS $$
DECLARE
    "total_revenue" DECIMAL(10, 2);
BEGIN
    SELECT SUM(amount) INTO "total_revenue" FROM "payment_details";
    RETURN "total_revenue";
END;
$$ LANGUAGE plpgsql;

-- Create a trigger to update car availability after reservation
CREATE OR REPLACE FUNCTION update_car_availability() RETURNS TRIGGER AS $$
BEGIN
    UPDATE "car" SET is_available = FALSE WHERE id = NEW.car_id;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_reservation_insert
    AFTER INSERT ON "reservation"
    FOR EACH ROW
EXECUTE FUNCTION update_car_availability();

-- Demonstrating a transaction with an appropriate level of isolation
BEGIN;

-- Set transaction isolation level
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;