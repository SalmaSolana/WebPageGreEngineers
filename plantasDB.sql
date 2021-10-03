CREATE DATABASE PlantasDB;	
USE PlantasDB;

--Cities Table
CREATE TABLE Cities(
	cityID INT PRIMARY KEY NOT NULL,
	city_name VARCHAR (100) NOT NULL,
	city_state VARCHAR (100) NOT NULL,
);

--Event Type Table
CREATE TABLE Event_Type (
	eventTypeID INT PRIMARY KEY NOT NULL,
	event_type_name VARCHAR (100) NOT NULL
);

--Event Record Table
CREATE TABLE Event_Record(
	eventID INT PRIMARY KEY NOT NULL,
	event_name VARCHAR (100) NOT NULL,
	event_date DATE,
	event_typeID INT NOT NULL,
	event_attendace INT NOT NULL,
	event_cityID INT NOT NULL

	CONSTRAINT FK_EVENT_TYPE
	FOREIGN KEY (event_typeID)
	REFERENCES Event_Type (eventTypeID)
);

--Event Assistants Table
CREATE TABLE Event_Assistants(
	assistantID INT PRIMARY KEY NOT NULL,
	assis_name VARCHAR (100) NOT NULL,
	assis_lastname VARCHAR (100) NOT NULL,
	assis_age SMALLINT NOT NULL
);

--Event Attendance Table
CREATE TABLE Event_Attendance(
	EA_assitantID INT NOT NULL,
	EA_eventID INT NOT NULL,
	EA_date DATE,

	CONSTRAINT FK_EVENT_ASSISTANCE
	FOREIGN KEY (EA_assitantID)
	REFERENCES Event_Assistants (assistantID),

	CONSTRAINT FK_EVENT_ID
	FOREIGN KEY (EA_eventID)
	REFERENCES Event_Record (eventID) 
);

--Customers Table
CREATE TABLE Customers (
	customerID INT PRIMARY KEY NOT NULL,
	cus_name VARCHAR (100) NOT NULL,
	cus_lastname VARCHAR (100) NOT NULL,
	cus_age SMALLINT NOT NULL,
	cus_cityID INT NOT NULL,

	CONSTRAINT FK_CUSTOMER_CITY
	FOREIGN KEY (cus_cityID)
	REFERENCES Cities (cityID)
);

--Collaborators Table
CREATE TABLE Collaborators(
	collaboratorID INT PRIMARY KEY NOT NULL,
	col_customerID INT NOT NULL,
	col_join_date DATE,

	CONSTRAINT FK_CUSTOMER_TO_COLLABORATOR
	FOREIGN KEY (col_customerID)
	REFERENCES Customers (customerID)
);

--Greenhouses Table
CREATE TABLE Greenhouses(
	greenhousesID INT PRIMARY KEY NOT NULL,
	gh_cityID INT NOT NULL,
	gh_realease_date DATE,
	gh_capacity INT NOT NULL,
	gh_is_own BIT NOT NULL,

	CONSTRAINT FK_GREENHOUSE_CITY
	FOREIGN KEY (gh_cityID)
	REFERENCES Cities (cityID)
);

--Lotes Table
CREATE TABLE Lotes(
	loteID INT PRIMARY KEY NOT NULL,
	lote_realease_date DATE,
	lote_capacity INT NOT NULL,
	lote_greenhouseID INT NOT NULL,

	CONSTRAINT FK_LOTE_GREENHOUSE
	FOREIGN KEY (lote_greenhouseID)
	REFERENCES Greenhouses (greenhousesID)
);

-- Todos Juntos Program Table
CREATE TABLE Todos_Juntos (
	todos_juntos_recordID INT PRIMARY KEY NOT NULL,
	td_collaboratorID INT NOT NULL,
	td_loteID INT NOT NULL,
	td_delivery_date DATE,
	td_recovery_date DATE,

	CONSTRAINT FK_COLLABORATOR_PROGRAM
	FOREIGN KEY (td_collaboratorID)
	REFERENCES Collaborators (collaboratorID),

	CONSTRAINT FK_LOTE_PROGRAM
	FOREIGN KEY (td_loteID)
	REFERENCES Lotes (loteID)
);

--Product Type Table
CREATE TABLE Product_Type (
	product_typeID INT PRIMARY KEY NOT NULL,
	prod_type_name VARCHAR (100) NOT NULL,
	prod_type_release_name DATE
);

--Products Table
CREATE TABLE Products (
	productID INT PRIMARY KEY NOT NULL,
	prod_name VARCHAR (100) NOT NULL,
	prod_typeID INT NOT NULL,
	prod_raelease_date DATE,
	prod_is_active BIT NOT NULL,

	CONSTRAINT FK_PRODUCT_TYPE
	FOREIGN KEY (prod_typeID)
	REFERENCES Product_Type (product_typeID)
);

--Courses Table
CREATE TABLE Courses(
	courseID INT PRIMARY KEY NOT NULL,
	course_productID INT NOT NULL,
	course_name VARCHAR (100) NOT NULL,
	course_teacher VARCHAR (200) NOT NULL,
	course_details TEXT,

	CONSTRAINT FK_PRODUCT_ID_COURSES
	FOREIGN KEY (course_productID) 
	REFERENCES Products (productID)
);

--Plants Table
CREATE TABLE Plants_Inv (
	plantID INT PRIMARY KEY NOT NULL,
	plant_productID INT NOT NULL,
	plant_weight INT NOT NULL,
	plant_specie VARCHAR (100) NOT NULL,
	plant_loteID INT NOT NULL,

	CONSTRAINT FK_PRODUCT_ID_PLANTS
	FOREIGN KEY (plant_productID) 
	REFERENCES Products (productID)
);

--Orders Table 
CREATE TABLE Orders (
	orderID INT PRIMARY KEY NOT NULL,
	order_date SMALLDATETIME NOT NULL,
	order_customerID INT NOT NULL,
	order_productID INT NOT NULL,

	CONSTRAINT FK_CUSTOMER_ORDERS
	FOREIGN KEY (order_customerID)
	REFERENCES Customers (customerID),

	CONSTRAINT FK_PRODUCT_ORDERS
	FOREIGN KEY (order_productID)
	REFERENCES Products (productID)
);