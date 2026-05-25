-- Ilocos Food Products — Sanitation Standard Operating Procedures (SSOP) Database (3NF)
-- MySQL 8.0+

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS stock_management_logs;
DROP TABLE IF EXISTS cleaning_logs;
DROP TABLE IF EXISTS oil_temperature_logs;
DROP TABLE IF EXISTS pest_control_logs;
DROP TABLE IF EXISTS delivery_truck_logs;
DROP TABLE IF EXISTS raw_material_logs;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS suppliers;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    initials VARCHAR(10) NOT NULL,
    role VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE suppliers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    contact_info TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE raw_material_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    supplier_id BIGINT UNSIGNED NOT NULL,
    agreed_scheduled_date DATE NULL,
    receiving_date DATE NOT NULL,
    time_received TIME NOT NULL,
    delivery_vehicle_id VARCHAR(80) NULL,
    qc_inspector_id BIGINT UNSIGNED NOT NULL,
    raw_material VARCHAR(150) NOT NULL,
    packaging_condition ENUM('GOOD', 'DAMAGED') NOT NULL DEFAULT 'GOOD',
    moisture_content_or_expiry VARCHAR(150) NULL,
    within_specs TINYINT(1) NOT NULL DEFAULT 1,
    quantity DECIMAL(10, 2) NOT NULL,
    status ENUM('ACCEPTED', 'REJECTED') NOT NULL DEFAULT 'ACCEPTED',
    received_by_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_raw_material_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
    CONSTRAINT fk_raw_material_qc_inspector FOREIGN KEY (qc_inspector_id) REFERENCES users(id),
    CONSTRAINT fk_raw_material_received_by FOREIGN KEY (received_by_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE delivery_truck_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    truck_plate_no VARCHAR(20) NOT NULL,
    driver_name VARCHAR(100) NOT NULL,
    checked_by_id BIGINT UNSIGNED NOT NULL,
    inspection_date DATE NOT NULL,
    inspection_time TIME NOT NULL,
    exterior_condition ENUM('CLEAN', 'DIRTY') NOT NULL DEFAULT 'CLEAN',
    interior_condition ENUM('CLEAN', 'DIRTY') NOT NULL DEFAULT 'CLEAN',
    odor ENUM('NORMAL', 'UNUSUAL') NOT NULL DEFAULT 'NORMAL',
    pest_activity TINYINT(1) NOT NULL DEFAULT 0,
    sanitized TINYINT(1) NOT NULL DEFAULT 1,
    maintenance_issues TINYINT(1) NOT NULL DEFAULT 0,
    corrective_action TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_delivery_truck_checked_by FOREIGN KEY (checked_by_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pest_control_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    inspection_date DATE NOT NULL,
    inspector_id BIGINT UNSIGNED NOT NULL,
    inspection_area VARCHAR(150) NOT NULL,
    pest_activity_observed TINYINT(1) NOT NULL DEFAULT 0,
    type_of_pest VARCHAR(100) NULL,
    corrective_action_taken TEXT NULL,
    verified_by_qa_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pest_control_inspector FOREIGN KEY (inspector_id) REFERENCES users(id),
    CONSTRAINT fk_pest_control_verified_by FOREIGN KEY (verified_by_qa_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE oil_temperature_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    production_date DATE NOT NULL,
    batch_lot_no VARCHAR(80) NOT NULL,
    operator_id BIGINT UNSIGNED NOT NULL,
    time_checked TIME NOT NULL,
    oil_temperature_c DECIMAL(5, 2) NOT NULL,
    corrective_action TEXT NULL,
    verified_by_qa_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_oil_temp_operator FOREIGN KEY (operator_id) REFERENCES users(id),
    CONSTRAINT fk_oil_temp_verified_by FOREIGN KEY (verified_by_qa_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cleaning_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_date DATE NOT NULL,
    log_time TIME NOT NULL,
    area_of_concern VARCHAR(150) NOT NULL,
    standard_met TINYINT(1) NOT NULL DEFAULT 1,
    action_taken TEXT NULL,
    sanitizer_used VARCHAR(100) NULL,
    performed_by_id BIGINT UNSIGNED NOT NULL,
    checked_by_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cleaning_performed_by FOREIGN KEY (performed_by_id) REFERENCES users(id),
    CONSTRAINT fk_cleaning_checked_by FOREIGN KEY (checked_by_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE stock_management_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    warehouse_location VARCHAR(150) NOT NULL,
    checked_by_id BIGINT UNSIGNED NOT NULL,
    log_date DATE NOT NULL,
    log_time TIME NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    batch_lot_no VARCHAR(80) NOT NULL,
    quantity_in_stock DECIMAL(10, 2) NOT NULL,
    expiry_date DATE NULL,
    storage_condition ENUM('GOODS', 'NEEDS ATTENTION') NOT NULL DEFAULT 'GOODS',
    fifo_fefo_followed TINYINT(1) NOT NULL DEFAULT 1,
    corrective_action TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_stock_checked_by FOREIGN KEY (checked_by_id) REFERENCES users(id),
    CONSTRAINT fk_stock_product FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO users (full_name, initials, role, created_at, updated_at) VALUES
('Maria Santos', 'MS', 'QA', NOW(), NOW()),
('John Reyes', 'JR', 'QA', NOW(), NOW()),
('Ana Cruz', 'AC', 'QC_INSPECTOR', NOW(), NOW()),
('Pedro Lim', 'PL', 'QC_INSPECTOR', NOW(), NOW()),
('Carlos Mendez', 'CM', 'OPERATOR', NOW(), NOW()),
('Lisa Wong', 'LW', 'OPERATOR', NOW(), NOW()),
('PestCo Inc', 'PC', 'PEST_INSPECTOR', NOW(), NOW());

INSERT INTO suppliers (name, contact_info, created_at, updated_at) VALUES
('Fresh Farms Co', 'contact@freshfarms.example', NOW(), NOW()),
('Dairy Direct', NULL, NOW(), NOW()),
('Grain Suppliers Ltd', 'orders@grain.example', NOW(), NOW());

INSERT INTO products (name, category, created_at, updated_at) VALUES
('Frozen Nuggets', 'Frozen', NOW(), NOW()),
('Breaded Fish', 'Frozen', NOW(), NOW()),
('Veggie Patties', 'Frozen', NOW(), NOW());

INSERT INTO raw_material_logs (supplier_id, agreed_scheduled_date, receiving_date, time_received, delivery_vehicle_id, qc_inspector_id, raw_material, packaging_condition, moisture_content_or_expiry, within_specs, quantity, status, received_by_id, created_at) VALUES
(1, CURDATE(), CURDATE(), '08:30:00', 'TRK-101', 4, 'Chicken Breast', 'GOOD', '12% moisture', 1, 500.00, 'ACCEPTED', 1, NOW()),
(2, NULL, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '09:15:00', NULL, 3, 'Milk Powder', 'DAMAGED', 'Exp 2026-08', 0, 250.00, 'REJECTED', 2, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(3, DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), '07:45:00', 'TRK-205', 4, 'Wheat Flour', 'GOOD', NULL, 1, 1000.00, 'ACCEPTED', 4, DATE_SUB(NOW(), INTERVAL 2 DAY));

INSERT INTO delivery_truck_logs (truck_plate_no, driver_name, checked_by_id, inspection_date, inspection_time, exterior_condition, interior_condition, odor, pest_activity, sanitized, maintenance_issues, corrective_action, created_at) VALUES
('ABC-1234', 'Juan Dela Cruz', 1, CURDATE(), '07:00:00', 'CLEAN', 'CLEAN', 'NORMAL', 0, 1, 0, NULL, NOW()),
('XYZ-5678', 'Rosa Garcia', 2, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:30:00', 'DIRTY', 'CLEAN', 'UNUSUAL', 1, 1, 0, 'Interior deep clean required', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('DEF-9012', 'Miguel Torres', 3, DATE_SUB(CURDATE(), INTERVAL 3 DAY), '06:45:00', 'CLEAN', 'DIRTY', 'NORMAL', 0, 0, 1, 'Scheduled maintenance', DATE_SUB(NOW(), INTERVAL 3 DAY));

INSERT INTO pest_control_logs (inspection_date, inspector_id, inspection_area, pest_activity_observed, type_of_pest, corrective_action_taken, verified_by_qa_id, created_at) VALUES
(CURDATE(), 7, 'Warehouse B', 0, NULL, NULL, 1, NOW()),
(DATE_SUB(CURDATE(), INTERVAL 2 DAY), 7, 'Receiving Dock', 1, 'Rodents', 'Bait stations replaced', 4, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(DATE_SUB(CURDATE(), INTERVAL 5 DAY), 7, 'Production Floor A', 1, 'Insects', 'UV trap serviced', NULL, DATE_SUB(NOW(), INTERVAL 5 DAY));

INSERT INTO oil_temperature_logs (production_date, batch_lot_no, operator_id, time_checked, oil_temperature_c, corrective_action, verified_by_qa_id, created_at) VALUES
(CURDATE(), 'OIL-2026-100', 5, '10:00:00', 175.50, NULL, 1, NOW()),
(CURDATE(), 'OIL-2026-101', 6, '14:30:00', 182.00, NULL, NULL, NOW()),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'OIL-2026-099', 5, '09:00:00', 168.25, 'Adjusted fryer setpoint', 3, DATE_SUB(NOW(), INTERVAL 1 DAY));

INSERT INTO cleaning_logs (log_date, log_time, area_of_concern, standard_met, action_taken, sanitizer_used, performed_by_id, checked_by_id, created_at) VALUES
(CURDATE(), '06:00:00', 'Production Floor A', 1, NULL, 'Quat Sanitizer', 1, 2, NOW()),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '18:30:00', 'Packaging Room', 0, 'Re-cleaned conveyor belts', 'Chlorine-based', 3, 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(DATE_SUB(CURDATE(), INTERVAL 4 DAY), '07:15:00', 'Cold Storage', 1, NULL, 'Quat Sanitizer', 2, NULL, DATE_SUB(NOW(), INTERVAL 4 DAY));

INSERT INTO stock_management_logs (warehouse_location, checked_by_id, log_date, log_time, product_id, batch_lot_no, quantity_in_stock, expiry_date, storage_condition, fifo_fefo_followed, corrective_action, created_at) VALUES
('Warehouse A - Rack 1', 4, CURDATE(), '11:00:00', 1, 'PB-2026-100', 1200.00, DATE_ADD(CURDATE(), INTERVAL 180 DAY), 'GOODS', 1, NULL, NOW()),
('Warehouse B - Cold Room', 2, CURDATE(), '11:30:00', 2, 'PB-2026-101', 800.00, DATE_ADD(CURDATE(), INTERVAL 90 DAY), 'GOODS', 1, NULL, NOW()),
('Warehouse A - Rack 3', 3, DATE_SUB(CURDATE(), INTERVAL 2 DAY), '10:00:00', 3, 'PB-2026-102', 450.00, DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'NEEDS ATTENTION', 0, 'Moved to front for FEFO', DATE_SUB(NOW(), INTERVAL 2 DAY));
