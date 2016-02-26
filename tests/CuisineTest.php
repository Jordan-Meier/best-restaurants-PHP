<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Cuisine::deleteAll();
          Restaurant::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $type = "Thai";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_Cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $type = "Thai";
            $type2 = "Indian";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($type2);
            $test_Cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_Cuisine, $test_Cuisine2], $result);
        }

        function test_getRestaurants()
        {
            //Arrange
            $type = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            // $test_cuisine_id = $test_cuisine->getId();

            $name = "Por Que No";
            $happy_hour = 1;
            $address = "123 N Mississippi St";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $happy_hour, $address, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Taco Time";
            $happy_hour2 = 0;
            $address2 = "1234 Wherever St";
            $cuisine_id2 = $test_cuisine->getId();
            $test_restaurant2 = new Restaurant($id, $name2, $happy_hour2, $address2, $cuisine_id2);
            $test_restaurant2->save();

            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $type = "Thai";
            $type2 = "Indian";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($type2);
            $test_Cuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $type = "Thai";
            $type2 = "Indian";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($type2);
            $test_Cuisine2->save();

            //Act
            $result = Cuisine::find($test_Cuisine->getId());

            //Assert
            $this->assertEquals($test_Cuisine, $result);
        }

        function testUpdate()
        {
            //Arrange
            $type = "Indian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $new_type = "Italian";

            //Act
            $test_cuisine->update($new_type);

            //Assert
            $this->assertEquals("Italian", $test_cuisine->getType());
        }

        function testDelete()
        {
            //Arrange
            $type = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $type2 = "Thai";
            $test_cuisine2 = new Cuisine($type2, $id);
            $test_cuisine2->save();


            //Act
            $test_cuisine->delete();

            //Assert
            $this->assertEquals([$test_cuisine2], Cuisine::getAll());
        }

        function testDelete_CuisineRestaurants()
        {
            //Arrange
            $type = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Javiers";
            $happy_hour = 0;
            $address = "123 NW street";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id = null, $name, $happy_hour, $address, $cuisine_id);
            $test_restaurant->save();


            //Act
            $test_cuisine->delete();

            //Assert
            $this->assertEquals([], Restaurant::getAll());
        }

    }

?>
