-- Food Safety & Quality Assurance Monitoring Database
-- MySQL 8.0+

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS stock_management_logs;
DROP TABLE IF EXISTS cleaning_logs;
DROP TABLE IF EXISTS oil_temperature_logs;
DROP TABLE IF EXISTS pest_control_logs;
DROP TABLE IF EXISTS delivery_truck_logs;
DROP TABLE IF EXISTS raw_material_logs;
DROP TABLE IF EXISTS hygiene_compliance_logs;
DROP TABLE IF EXISTS production_inspections;
DROP TABLE IF EXISTS raw_material_inspections;
DROP TABLE IF EXISTS temperature_logs;
DROP TABLE IF EXISTS sanitation_logs;

CREATE TABLE raw_material_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    supplier_name VARCHAR(150) NOT NULL,
    agreed_scheduled_date DATE NULL,
    receiving_date DATE NOT NULL,
    time_received TIME NOT NULL,
    delivery_vehicle_id VARCHAR(80) NULL,
    qc_inspector VARCHAR(100) NOT NULL,
    raw_material VARCHAR(150) NOT NULL,
    packaging_condition ENUM('GOOD', 'DAMAGED') NOT NULL DEFAULT 'GOOD',
    moisture_content_or_expiry VARCHAR(150) NULL,
    within_specs TINYINT(1) NOT NULL DEFAULT 1,
    quantity DECIMAL(10, 2) NOT NULL,
    status ENUM('ACCEPTED', 'REJECTED') NOT NULL DEFAULT 'ACCEPTED',
    inspector_initials VARCHAR(10) NOT NULL,
    received_by VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE delivery_truck_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    truck_plate_no VARCHAR(20) NOT NULL,
    driver_name VARCHAR(100) NOT NULL,
    checked_by VARCHAR(100) NOT NULL,
    inspection_date DATE NOT NULL,
    inspection_time TIME NOT NULL,
    exterior_condition ENUM('CLEAN', 'DIRTY') NOT NULL DEFAULT 'CLEAN',
    interior_condition ENUM('CLEAN', 'DIRTY') NOT NULL DEFAULT 'CLEAN',
    odor ENUM('NORMAL', 'UNUSUAL') NOT NULL DEFAULT 'NORMAL',
    pest_activity TINYINT(1) NOT NULL DEFAULT 0,
    sanitized TINYINT(1) NOT NULL DEFAULT 1,
    maintenance_issues TINYINT(1) NOT NULL DEFAULT 0,
    inspector_initials VARCHAR(10) NOT NULL,
    corrective_action TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pest_control_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    inspection_date DATE NOT NULL,
    inspector_name VARCHAR(100) NOT NULL,
    inspection_area VARCHAR(150) NOT NULL,
    pest_activity_observed TINYINT(1) NOT NULL DEFAULT 0,
    type_of_pest VARCHAR(100) NULL,
    corrective_action_taken TEXT NULL,
    inspector_initials VARCHAR(10) NOT NULL,
    verified_by_qa VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE oil_temperature_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    production_date DATE NOT NULL,
    batch_lot_no VARCHAR(80) NOT NULL,
    operator_name_id VARCHAR(100) NOT NULL,
    time_checked TIME NOT NULL,
    oil_temperature_c DECIMAL(5, 2) NOT NULL,
    operator_initial VARCHAR(10) NOT NULL,
    corrective_action TEXT NULL,
    verified_by_qa VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cleaning_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_date DATE NOT NULL,
    log_time TIME NOT NULL,
    area_of_concern VARCHAR(150) NOT NULL,
    standard_met TINYINT(1) NOT NULL DEFAULT 1,
    action_taken TEXT NULL,
    sanitizer_used VARCHAR(100) NULL,
    performed_by VARCHAR(100) NOT NULL,
    checked_by VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE stock_management_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    warehouse_location VARCHAR(150) NOT NULL,
    checked_by VARCHAR(100) NOT NULL,
    log_date DATE NOT NULL,
    log_time TIME NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    batch_lot_no VARCHAR(80) NOT NULL,
    quantity_in_stock DECIMAL(10, 2) NOT NULL,
    expiry_date DATE NULL,
    storage_condition ENUM('GOODS', 'NEEDS ATTENTION') NOT NULL DEFAULT 'GOODS',
    fifo_fefo_followed TINYINT(1) NOT NULL DEFAULT 1,
    inspector_initials VARCHAR(10) NOT NULL,
    corrective_action TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO raw_material_logs (supplier_name, agreed_scheduled_date, receiving_date, time_received, delivery_vehicle_id, qc_inspector, raw_material, packaging_condition, moisture_content_or_expiry, within_specs, quantity, status, inspector_initials, received_by, created_at) VALUES
('Fresh Farms Co', CURDATE(), CURDATE(), '08:30:00', 'TRK-101', 'Pedro Lim', 'Chicken Breast', 'GOOD', '12% moisture', 1, 500.00, 'ACCEPTED', 'PL', 'Maria Santos', NOW()),
('Dairy Direct', NULL, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '09:15:00', NULL, 'Ana Cruz', 'Milk Powder', 'DAMAGED', 'Exp 2026-08', 0, 250.00, 'REJECTED', 'AC', 'John Reyes', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('Grain Suppliers Ltd', DATE_SUB(CURDATE(), INTERVAL 2 DAY), DATE_SUB(CURDATE(), INTERVAL 2 DAY), '07:45:00', 'TRK-205', 'Pedro Lim', 'Wheat Flour', 'GOOD', NULL, 1, 1000.00, 'ACCEPTED', 'PL', 'Pedro Lim', DATE_SUB(NOW(), INTERVAL 2 DAY));

INSERT INTO delivery_truck_logs (truck_plate_no, driver_name, checked_by, inspection_date, inspection_time, exterior_condition, interior_condition, odor, pest_activity, sanitized, maintenance_issues, inspector_initials, corrective_action, created_at) VALUES
('ABC-1234', 'Juan Dela Cruz', 'Maria Santos', CURDATE(), '07:00:00', 'CLEAN', 'CLEAN', 'NORMAL', 0, 1, 0, 'MS', NULL, NOW()),
('XYZ-5678', 'Rosa Garcia', 'John Reyes', DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:30:00', 'DIRTY', 'CLEAN', 'UNUSUAL', 1, 1, 0, 'JR', 'Interior deep clean required', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('DEF-9012', 'Miguel Torres', 'Ana Cruz', DATE_SUB(CURDATE(), INTERVAL 3 DAY), '06:45:00', 'CLEAN', 'DIRTY', 'NORMAL', 0, 0, 1, 'AC', 'Scheduled maintenance', DATE_SUB(NOW(), INTERVAL 3 DAY));

INSERT INTO pest_control_logs (inspection_date, inspector_name, inspection_area, pest_activity_observed, type_of_pest, corrective_action_taken, inspector_initials, verified_by_qa, created_at) VALUES
(CURDATE(), 'PestCo Inc', 'Warehouse B', 0, NULL, NULL, 'PC', 'Maria Santos', NOW()),
(DATE_SUB(CURDATE(), INTERVAL 2 DAY), 'PestCo Inc', 'Receiving Dock', 1, 'Rodents', 'Bait stations replaced', 'PC', 'Pedro Lim', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'PestCo Inc', 'Production Floor A', 1, 'Insects', 'UV trap serviced', 'PC', NULL, DATE_SUB(NOW(), INTERVAL 5 DAY));

INSERT INTO oil_temperature_logs (production_date, batch_lot_no, operator_name_id, time_checked, oil_temperature_c, operator_initial, corrective_action, verified_by_qa, created_at) VALUES
(CURDATE(), 'OIL-2026-100', 'Carlos Mendez', '10:00:00', 175.50, 'CM', NULL, 'Maria Santos', NOW()),
(CURDATE(), 'OIL-2026-101', 'Lisa Wong', '14:30:00', 182.00, 'LW', NULL, NULL, NOW()),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'OIL-2026-099', 'Carlos Mendez', '09:00:00', 168.25, 'CM', 'Adjusted fryer setpoint', 'Ana Cruz', DATE_SUB(NOW(), INTERVAL 1 DAY));

INSERT INTO cleaning_logs (log_date, log_time, area_of_concern, standard_met, action_taken, sanitizer_used, performed_by, checked_by, created_at) VALUES
(CURDATE(), '06:00:00', 'Production Floor A', 1, NULL, 'Quat Sanitizer', 'Maria Santos', 'John Reyes', NOW()),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '18:30:00', 'Packaging Room', 0, 'Re-cleaned conveyor belts', 'Chlorine-based', 'Ana Cruz', 'Maria Santos', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(DATE_SUB(CURDATE(), INTERVAL 4 DAY), '07:15:00', 'Cold Storage', 1, NULL, 'Quat Sanitizer', 'John Reyes', NULL, DATE_SUB(NOW(), INTERVAL 4 DAY));

INSERT INTO stock_management_logs (warehouse_location, checked_by, log_date, log_time, product_name, batch_lot_no, quantity_in_stock, expiry_date, storage_condition, fifo_fefo_followed, inspector_initials, corrective_action, created_at) VALUES
('Warehouse A - Rack 1', 'Pedro Lim', CURDATE(), '11:00:00', 'Frozen Nuggets', 'PB-2026-100', 1200.00, DATE_ADD(CURDATE(), INTERVAL 180 DAY), 'GOODS', 1, 'PL', NULL, NOW()),
('Warehouse B - Cold Room', 'John Reyes', CURDATE(), '11:30:00', 'Breaded Fish', 'PB-2026-101', 800.00, DATE_ADD(CURDATE(), INTERVAL 90 DAY), 'GOODS', 1, 'JR', NULL, NOW()),
('Warehouse A - Rack 3', 'Ana Cruz', DATE_SUB(CURDATE(), INTERVAL 2 DAY), '10:00:00', 'Veggie Patties', 'PB-2026-102', 450.00, DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'NEEDS ATTENTION', 0, 'AC', 'Moved to front for FEFO', DATE_SUB(NOW(), INTERVAL 2 DAY));
