<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Throwable;


class CategoriesSeeder extends Seeder
{

    /**
     * @return void
     * @throws Throwable
     */
    public function run(): void
    {
        foreach ($this->categories() as $category) {
            (new Category())
                ->set(key: 'name', value: $category)
                ->saveOrFail();
        }
    }

    /**
     * @return array
     */
    protected function categories(): array
    {
        return [
            'Aktivnosti',
            'Bezbednost',
            'Zelenilo',
            'Čistoća',
            'Pristupačnost',
        ];
    }
}
