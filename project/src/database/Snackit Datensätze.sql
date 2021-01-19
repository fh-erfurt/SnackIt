USE `SnackIt` ;

-- NOCH ABSOLUT UNFERTIG

-- -----------------------------------------------------
-- Data for table `Address` Geht
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Address` (`addressId`, `createdAt`, `updatedAt`, `country`, `state`, `zipcode`, `city`, `street`, `number`) VALUES (1, DEFAULT, NULL, 'Deutschland', 'Thüringen', '99869', 'Wangenheim', 'Grüne Gasse', '2');
INSERT INTO `Address` (`addressId`, `createdAt`, `updatedAt`, `country`, `state`, `zipcode`, `city`, `street`, `number`) VALUES (2, DEFAULT, NULL, 'Deutschland', 'Thüringen', '99085', 'Erfurt', 'Leipziger Straße', '15b');

COMMIT;

-- -----------------------------------------------------
-- Data for table `Account` Geht
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Account` (`accountid`, `createdAt`, `updatedAt`, `firstname`, `lastname`, `email`, `password`, `role`, `Addressid`) VALUES (1, DEFAULT, NULL, 'Lukas', 'Arnold', 'Jan204@t-online.de', 'Penis123', 1, 1);
INSERT INTO `Account` (`accountid`, `createdAt`, `updatedAt`, `firstname`, `lastname`, `email`, `password`, `role`, `Addressid`) VALUES (2, DEFAULT, NULL, 'Bernd', 'Benod', 'Biobernd@t-online.de', 'Bernand123', 0, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `Orders` Status 0 = versendet. Geht
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Orders` (`OrderId`, `createdAt`, `updatedAt`, `Status`, `Account_AccountID`, `Address_AddressId`, `FirstName`, `LastName`) VALUES (1, DEFAULT, NULL, 0, 2, 2, 'Bernd', 'Benod');
INSERT INTO `Orders` (`OrderId`, `createdAt`, `updatedAt`, `Status`, `Account_AccountID`, `Address_AddressId`, `FirstName`, `LastName`) VALUES (2, DEFAULT, NULL, 1, 1, 1, 'Lukas', 'Arnold');

COMMIT;
-- -----------------------------------------------------
-- Data for table `Product` prodType 0 = Snacks, 1 = Getränke, 2 = Bundles. Geht
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (1, DEFAULT, NULL, 'Pringles Original Chips 200g', 2.50, 0, 30);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (2, DEFAULT, NULL, 'Pringles Sour Cream & Onion Chips 200g', 2.60, 0, 45);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (3, DEFAULT, NULL, 'ja! Happy Knabberbox 300g', 3.20, 0, 54);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (4, DEFAULT, NULL, 'Maryland Studentenfutter 300g', 4.99, 0, 20);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (5, DEFAULT, NULL, 'Lorenz Geistes Blitzer 125g', 1.99, 0, 40);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (6, DEFAULT, NULL, 'Quelly Vita 10 ACE Getränk 1,5l(EINWEG)', 1.99, 1, 36);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (7, DEFAULT, NULL, 'Coca Cola Cherry ohne Zucker 1,5l(EINWEG)', 1.99, 1, 54);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (8, DEFAULT, NULL, 'Red Bull Energy Drink 0,25l(EINWEG)', 2.99, 1, 14);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (9, DEFAULT, NULL, 'Pringles Original Chips 200g und Coca Cola Cherry ohne Zucker 1,5l Bundle', 4.00, 2, 30);
INSERT INTO `Product` (`productId`, `createdAt`, `updatedAt`, `prodname`, `price`, `prodType`, `onStock`) VALUES (10, DEFAULT, NULL, 'Maryland Studentenfutter 300g und Red Bull Energy Drink 0,25l Bundle', 7.50, 2, 14);

COMMIT;

-- -----------------------------------------------------
-- Data for table `Product_to_Order` Geht
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Product_to_Order` (`ptoId`, `createdAt`, `updatedAt`, `productcount`, `orderId`, `productId`) VALUES (1, DEFAULT, NULL, 3, 1, 5);
INSERT INTO `Product_to_Order` (`ptoId`, `createdAt`, `updatedAt`, `productcount`, `orderId`, `productId`) VALUES (2, DEFAULT, NULL, 2, 1, 8);
INSERT INTO `Product_to_Order` (`ptoId`, `createdAt`, `updatedAt`, `productcount`, `orderId`, `productId`) VALUES (3, DEFAULT, NULL, 7, 1, 1);
INSERT INTO `Product_to_Order` (`ptoId`, `createdAt`, `updatedAt`, `productcount`, `orderId`, `productId`) VALUES (4, DEFAULT, NULL, 3, 2, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `Property` Geht
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (1, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Pringles Original Chips 200g.jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (2, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Pringles Sour Cream & Onion Chips 200g.jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (3, DEFAULT, NULL, DEFAULT, 'mainPicture', 'ja! Happy Knabberbox 300g.jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (4, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Maryland Studentenfutter 300g.jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (5, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Lorenz Geistes Blitzer 125g.jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (6, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Quelly Vita 10 ACE Getränk 1,5l(EINWEG).jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (7, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Coca Cola Cherry ohne Zucker 1,5l(EINWEG).jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (8, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Red Bull Energy Drink 0,25l(EINWEG).jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (9, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Pringles Original Chips 200g und Coca Cola Cherry ohne Zucker 1,5l Bundle.jpg');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (10, DEFAULT, NULL, DEFAULT, 'mainPicture', 'Maryland Studentenfutter 300g und Red Bull Energy Drink 0,25l Bundle.jpg');

INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (11, DEFAULT, NULL, DEFAULT, 'inside', 'Chips');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (12, DEFAULT, NULL, DEFAULT, 'inside', 'Nüsse');
INSERT INTO `Property` (`propertyId`, `createdAt`, `updatedAt`, `type`, `name`, `value`) VALUES (13, DEFAULT, NULL, DEFAULT, 'inside', 'Cola');
-- Und so weiter halt

COMMIT;

-- -----------------------------------------------------
-- Data for table `Product_has_Property`
-- -----------------------------------------------------
START TRANSACTION;
USE `SnackIt`;
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (1, DEFAULT, NULL, 1, 1);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (2, DEFAULT, NULL, 2, 2);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (3, DEFAULT, NULL, 3, 3);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (4, DEFAULT, NULL, 4, 4);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (5, DEFAULT, NULL, 5, 5);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (6, DEFAULT, NULL, 6, 6);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (7, DEFAULT, NULL, 7, 7);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (8, DEFAULT, NULL, 8, 8);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (9, DEFAULT, NULL, 9, 9);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (10, DEFAULT, NULL, 10, 10);

INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (11, DEFAULT, NULL, 1, 11);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (12, DEFAULT, NULL, 2, 11);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (13, DEFAULT, NULL, 4, 12);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (14, DEFAULT, NULL, 5, 12);
INSERT INTO `Product_has_Property` (`phpId`, `createdAt`, `updatedAt`, `productId`, `propertyId`) VALUES (15, DEFAULT, NULL, 7, 13);

COMMIT;

