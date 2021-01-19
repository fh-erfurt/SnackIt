USE `SnackIt` ;

-- NOCH ABSOLUT UNFERTIG

-- -----------------------------------------------------
-- Data for table `Address`
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Address` (`addressId`, `createdAt`, `updatedAt`, `country`, `state`, `zipcode`, `city`, `street`, `number`) VALUES (1, DEFAULT, NULL, 'Deutschland', 'Thüringen', '99085', 'Erfurt', 'Altonaer Straße', '3');
INSERT INTO `Address` (`addressId`, `createdAt`, `updatedAt`, `country`, `state`, `zipcode`, `city`, `street`, `number`) VALUES (2, DEFAULT, NULL, 'Deutschland', 'Thüringen', '99085', 'Erfurt', 'Leipziger Straße', '15b');

COMMIT;

-- -----------------------------------------------------
-- Data for table `Product`
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `name`, `price`, `prodType`, `onStock`) VALUES (1, DEFAULT, NULL, 'Intel Core I7-9700', 299.99, 1, 25);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `name`, `price`, `prodType`, `onStock`) VALUES (2, DEFAULT, NULL, 'Intel Core I7-9700T', 309.99, 1, 45);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `name`, `price`, `prodType`, `onStock`) VALUES (3, DEFAULT, NULL, 'Intel Core i7-9700K', 349.99, 1, 54);

COMMIT;

-- -----------------------------------------------------
-- Data for table `Product_has_Property`
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (DEFAULT, DEFAULT, NULL, 1, 52);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (DEFAULT, DEFAULT, NULL, 1, 38);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (DEFAULT, DEFAULT, NULL, 1, 40);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (DEFAULT, DEFAULT, NULL, 1, 46);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (DEFAULT, DEFAULT, NULL, 1, 53);

COMMIT;

-- -----------------------------------------------------
-- Data for table `Property`
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (56, DEFAULT, NULL, DEFAULT, 'mainPicture', 'geforce-gtx-1060-foundersedtitonpg.png');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (1, DEFAULT, NULL, DEFAULT, 'Prozessorsockel', 'LGA 1150');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (2, DEFAULT, NULL, DEFAULT, 'Prozessorsockel', 'LGA 1151');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (3, DEFAULT, NULL, DEFAULT, 'Prozessorsockel', 'LGA 1155');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (4, DEFAULT, NULL, DEFAULT, 'Prozessorsockel', 'LGA 1156');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (5, DEFAULT, NULL, DEFAULT, 'Prozessorsockel', 'LGA 2011');

COMMIT;


-- -----------------------------------------------------
-- Data for table `User`
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `User` (`userId`, `createdAt`, `updatedAt`, `firstname`, `lastname`, `email`, `password`, `addressId`, `role`) VALUES (DEFAULT, DEFAULT, NULL, 'Admin', 'Admin', 'admin@pc4u.de', '$2y$10$Sd93g8RwevRM6F/gp8eGiuUPtwh.pacVeABatDbFWArxXniB6N2pC', 1, 1);
INSERT INTO `User` (`userId`, `createdAt`, `updatedAt`, `firstname`, `lastname`, `email`, `password`, `addressId`, `role`) VALUES (DEFAULT, DEFAULT, NULL, 'Max', 'Mustermann', 'max.mustermann@fh-erfurt.de', '$2y$10$NFY2C4qKPI4msX24IArOAOsLd/MEmJUDr5ArF0v0TZGXRFpK6Hrii', 2, 0);

COMMIT;