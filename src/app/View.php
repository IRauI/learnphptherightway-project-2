<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

/**
 * View class, used to manage all the views
 */
class View
{

    public function __construct(
        protected string $path,
        protected array $params = []
    )
    {

    }

    /**
     * renders the view using the php files in /views
     */
    public function render() : string
    {
        $viewPath = VIEW_PATH . '/' . $this->path . '.php';
        if(!file_exists($viewPath)){
            throw new ViewNotFoundException();
        }
        ob_start();
        include $viewPath;
        return (string) ob_get_clean(); 
    }

    /**
     * Static function, makes a new View for the specific path, parameters can be passed
     */
    public static function make(string $path, array $params = []) : View {
        return new View($path, $params);
    }

    public function __toString()
    {
        return $this->render();
    }
}