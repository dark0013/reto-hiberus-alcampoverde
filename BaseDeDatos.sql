

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `mediapp19` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE `tbl_adm_medical_appointment` (
  `id` int(11) NOT NULL,
  `identification` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `specialty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `tbl_adm_medical_appointment` (`id`, `identification`, `name`, `appointment_date`, `specialty_id`) VALUES
(1, '0994550193', 'Maggie Campoverde', '2025-08-16 00:00:00', 2),
(2, '0910074994', 'mikela lopez', '2025-08-24 00:00:00', 1),
(3, '0931779292', 'Mikela Lopéz', '2025-08-23 00:00:00', 1),
(4, '0931779292', 'Alain Campoverde', '2025-08-18 00:00:00', 3);



CREATE TABLE `tbl_adm_patient` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(2) NOT NULL,
  `identification` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `tbl_adm_patient` (`id`, `name`, `age`, `identification`) VALUES
(1, 'José Inga', 23, '0931779292'),
(2, 'Maggie Campoverde', 55, '0994550193');



CREATE TABLE `tbl_adm_specialty` (
  `id` int(11) NOT NULL,
  `specialty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `tbl_adm_specialty` (`id`, `specialty`) VALUES
(1, 'Medicina General'),
(2, 'Pediatría'),
(3, 'Dermatología');


ALTER TABLE `tbl_adm_medical_appointment`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tbl_adm_patient`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tbl_adm_specialty`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tbl_adm_medical_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


ALTER TABLE `tbl_adm_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;


ALTER TABLE `tbl_adm_specialty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
