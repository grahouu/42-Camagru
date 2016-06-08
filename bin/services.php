<?php
class Service {

}

foreach (glob('services/*Service.php') as $service) {
    require_once $service;
}
