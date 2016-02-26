<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $type = "thai";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();


            $name = "Mee Dee Thai";
            $happy_hour = 0;
            $address = "1234 Greelee St";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $happy_hour, $address, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = Restaurant::getAll();
            //Assert
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $type = "thai";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Mee Dee Thai";
            $happy_hour = 0;
            $address = "1234 Greelee St";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $happy_hour, $address, $cuisine_id);
            $test_restaurant->save();


            $name2 = "Pok Pok";
            $happy_hour2 = 1;
            $address2 = "1234 Division St";
            $cuisine_id2 = $test_cuisine->getId();
            $test_restaurant2 = new Restaurant($id, $name2, $happy_hour2, $address2, $cuisine_id2);
            $test_restaurant2->save();


            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $type = "thai";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Mee Dee Thai";
            $happy_hour = 0;
            $address = "1234 Greelee St";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $happy_hour, $address, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Pok Pok";
            $happy_hour2 = 1;
            $address2 = "1234 Division St";
            $cuisine_id2 = $test_cuisine->getId();
            $test_restaurant2 = new Restaurant($id, $name2, $happy_hour2, $address2, $cuisine_id2);
            $test_restaurant2->save();

            //Act
            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $type = "thai";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Mee Dee Thai";
            $happy_hour = 0;
            $address = "1234 Greelee St";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $happy_hour, $address, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Pok Pok";
            $happy_hour2 = 1;
            $address2 = "1234 Division St";
            $cuisine_id2 = $test_cuisine->getId();
            $test_restaurant2 = new Restaurant($id, $name2, $happy_hour2, $address2, $cuisine_id2);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::find($test_restaurant->getId());

            //Assert
            $this->assertEquals($test_restaurant, $result);
        }

        function testUpdateRestaurant()
        {
            //Arrange
            $type = 'Mexican';
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();

            $name = "Javiers";
            $happy_hour = 0;
            $address = "123 NW street";
            $cuisine_id = $test_Cuisine->getId();
            $test_restaurant = new Restaurant($id = null, $name, $happy_hour, $address, $cuisine_id);
            $test_restaurant->save();

            $new_name = "Por Que";
            $new_happy_hour = 1;
            $new_address = "124 SE street";


            //Act
            $test_restaurant->updateRestaurant($new_name, $new_happy_hour, $new_address);
            // $result = Restaurant::getAll();

            //Assert
            $this->assertEquals(["Por Que", 1, "124 SE street"], [$test_restaurant->getName(), $test_restaurant->getHappyHour(), $test_restaurant->getAddress()]);
        }

    }

?>
