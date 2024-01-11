<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            'user' => 'admin',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Husni'
                ],
                [
                    'id' => '2',
                    'todo' => 'Ramdani'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('Husni')
            ->assertSeeText('2')
            ->assertSeeText('Ramdani');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'admin'
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'admin'
        ])->post('/todolist', [
            'todo' => 'mengerjakan pr'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            'user' => 'admin',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Husni'
                ],
                [
                    'id' => '2',
                    'todo' => 'Ramdani'
                ]
            ]
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
