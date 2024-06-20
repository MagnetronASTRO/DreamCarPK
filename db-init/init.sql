-- Create the user table
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    token VARCHAR(18) NULL,
    expire_time INT NULL
);

CREATE TABLE "user_tokens" (
    user_id INT REFERENCES "user"(id) ON DELETE CASCADE,
    token VARCHAR(64) NOT NULL,
    expiry INT NOT NULL,
PRIMARY KEY (user_id)
);

-- Create the role table
CREATE TABLE "role" (
    id SERIAL PRIMARY KEY,
    role_name VARCHAR(50) UNIQUE NOT NULL
);

-- Create the user_role table (many-to-many relationship)
CREATE TABLE "user_role" (
    user_id INT REFERENCES "user"(id) ON DELETE CASCADE,
    role_id INT REFERENCES "role"(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, role_id)
);

-- Create the car table
CREATE TABLE "car" (
    id SERIAL PRIMARY KEY,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    is_available BOOLEAN DEFAULT TRUE
);

CREATE TABLE "car_pricing" (
    id SERIAL PRIMARY KEY,
    car_id INT REFERENCES "car"(id) on DELETE CASCADE,
    day_price INT NOT NULL,
    month_price INT NOT NULL,
    km_price INT NOT NULL
);

CREATE TABLE "car_spec" (
    id SERIAL PRIMARY KEY,
    car_id INT REFERENCES "car"(id) on DELETE CASCADE,
    power INT NOT NULL,
    color VARCHAR(50) NOT NULL
);

CREATE TABLE "car_photo" (
    id SERIAL PRIMARY KEY,
    car_id INT REFERENCES "car"(id) ON DELETE CASCADE,
    photo_name VARCHAR(255) NOT NULL
);

-- Create the reservation table (one-to-many relationship with Users and Cars)
CREATE TABLE "reservation" (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES "user"(id) ON DELETE CASCADE,
    car_id INT REFERENCES "car"(id) ON DELETE CASCADE,
    reservation_date TIMESTAMP NOT NULL,
    return_date TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the payment_details table (one-to-one relationship with Reservations)
CREATE TABLE "payment_details" (
    id SERIAL PRIMARY KEY,
    reservation_id INT UNIQUE REFERENCES "reservation"(id) ON DELETE CASCADE,
    amount DECIMAL(10, 2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(50) NOT NULL
);

-- Insert initial roles
INSERT INTO role (role_name) VALUES ('admin'), ('customer');

-- Insert default admin user, default pass - admin123
INSERT INTO "user" (username, password, email) VALUES ('admin', '$2y$10$HS4yJbBKmryUqXYMjVmCJOY2ErCxOapOj8tsf3HwKcYk89XVBZpni', 'admin@example.com');
INSERT INTO "user_role" (user_id, role_id) VALUES (1, 1);

-- Insert initial car data
INSERT INTO "car" (make, model, year, is_available) VALUES ('Toyota', 'Corolla', 2022, TRUE);

-- Create a view for user reservations
CREATE VIEW "user_reservation" AS
SELECT
    u.username,
    u.email,
    r.reservation_date,
    r.return_date,
    c.make,
    c.model,
    c.year
FROM
    "user" u
        JOIN
    "reservation" r ON u.id = r.user_id
        JOIN
    "car" c ON r.car_id = c.id;

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

-- Sample transaction: Create a user, make a reservation, and insert payment details
-- DO $$
--     DECLARE
--         new_user_id INT;
--         new_reservation_id INT;
--     BEGIN
--         -- Insert new user pass - password123
--         INSERT INTO "user" (username, password, email) VALUES ('johndoe', '$2y$10$GXekgjtKYEqZYn5mlrvFDeKh9lVCtzEJSg2b8Y31JfdUcTcIp9X8K', 'john@example.com') RETURNING id INTO new_user_id;
--
--         -- Insert new reservation
--         INSERT INTO "reservation" (user_id, car_id, reservation_date, return_date)
--         VALUES (new_user_id, 1, '2024-06-07 10:00:00', '2024-06-10 10:00:00') RETURNING id INTO new_reservation_id;
--
--         -- Insert payment details
--         INSERT INTO "payment_details" (reservation_id, amount, payment_method)
--         VALUES (new_reservation_id, 150.00, 'Credit Card');
--     END;
-- $$;
--
-- COMMIT;