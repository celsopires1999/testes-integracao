<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $categoryKey
        );
    }

    public function testCreate()
    {
        // Test: passing only name
        $category = Category::create([
            'name' => 'test1'
        ]);
        $category->refresh();
        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
    
        // Test: passing null in description    
        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);
        $this->assertNull($category->description);

        // Test: passing a value in description
        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description'
        ]);
        $this->assertEquals('test_description', $category->description);

        // Test: passing is_active=true
        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);
    }
}
