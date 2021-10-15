<?php

namespace Migrations;

use Graille\Migration\MigrationInterface;
use Graille\Migration\Plan;

class M10000_create_table_restaurant implements MigrationInterface
{

    public function execute(Plan $plan)
    {
        $plan->create("restaurant")
            ->add('title', 'varchar(255)')
            ->add('description', 'text')
            ->add('image_url', 'varchar(255)')
            ->id();
    }
}
