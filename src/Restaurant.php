<?php
    class Restaurant
    {
        private $id;
        private $name;
        private $happy_hour;
        private $address;
        private $cuisine_id;

        function __construct($id = null, $name, $happy_hour, $address, $cuisine_id)
        {
            $this->id = $id;
            $this->name = $name;
            $this->happy_hour = $happy_hour;
            $this->address = $address;
            $this->cuisine_id = $cuisine_id;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setHappyHour($new_happy_hour)
        {
            $this->happy_hour = (string) $new_happy_hour;
        }

        function getHappyHour()
        {
            return $this->happy_hour;
        }

        function setAddress($new_address)
        {
            $this->address = (string) $new_address;
        }

        function getAddress()
        {
            return $this->address;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name, happy_hour, address, cuisine_id) VALUES ('{$this->getName()}', {$this->getHappyHour()}, '{$this->getAddress()}', {$this->getCuisineId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM  restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $happy_hour = $restaurant['happy_hour'];
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $address = $restaurant['address'];
                $new_restaurant = new Restaurant($id, $name, $happy_hour, $address, $cuisine_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;

        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }

    }
?>
