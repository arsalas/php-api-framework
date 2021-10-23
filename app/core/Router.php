<?php

namespace App\Core;

use App\Helpers\response;
use App\Helpers\Utils;
use \Waavi\Sanitizer\Sanitizer;

class Router
{

    // metodo http
    private $method;
    // path ruta
    private $uri;
    // match ruta
    private $route;
    // rutas de get
    private $get;
    //rutas de post
    private $post;
    //rutas de put
    private $put;
    //rutas de delete
    private $delete;
    // array de la ruta por /
    private $params;
    // Accion del controlador
    private $action;
    // parametros de la request
    private $request;
    // archivos enviados
    private $middleware;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        isset($_GET['uri']) && $_GET['uri'] !== ''  ?  $this->uri = $_GET['uri'] :  $this->uri = '/';
        $this->get = array();
        $this->params = array();
        $this->request = array();
        $this->middleware = array();
    }

    // Inicio router
    public function start()
    {
        $this->getParams($_POST);

        $match = $this->match();

        if ($match) {
            $this->action();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo "HTTP/1.1 404 Not Found";
            exit();
        }

        return null;
    }

    // Buscar la accion del controlador
    private function action()
    {
        $rmidd = array();

        if (isset($this->middleware[$this->method][$this->route]) && !empty($this->middleware[$this->method][$this->route])) {
            foreach ($this->middleware[$this->method][$this->route] as $middleware) {
                $middl = 'App\Middlewares\\' . $middleware;

                $result = new $middl($this->request, $rmidd);
                if (isset($this->params[0])) {
                    $a = $result->handle($this->params[0]);
                } else {
                    $a = $result->handle();
                }

                $rmidd[$middleware] = $a;
            }
        }
        $action = explode('@', $this->action);
        $controller = 'App\Controllers\\' . $action[0];
        $function = $action[1];

        $response = new $controller($rmidd, $this->request);
        $result = call_user_func_array(array($response, $function), $this->params);
      
        return response::json($result[0], $result[1]);
    }

    private function match()
    {
        $path = explode('/', $this->uri);
        $n = count($path);
        // Analizar todas las rutas
        $match = false;
        $method = strtolower($this->method);
        foreach ($this->$method as $row => $key) {
            $path2 = explode('/', $row);
            $n2 = count($path2);
            if ($n2 == $n) {
                // Comprobar si es la misma ruta
                $match = true;
                for ($i = 0; $i < $n2; $i++) {
                    if ($path[$i] != $path2[$i]) {
                        if (strpos($path2[$i], '{') === false) {
                            $match = false;
                            break;
                        } else {
                            $param = str_replace('{', '', $path2[$i]);
                            $param = str_replace('}', '', $param);
                            array_push($this->params, $path[$i]);
                        }
                    }
                }
                if ($match) {
                    $this->route = $row;
                    $this->action = $key;
                    break;
                }
            }
        }

        return $match;
    }

    public function get($uri, $action, $middleware = array())
    {
        $this->get[$uri] = $action;
        $this->middlewares('GET', $uri, $middleware);
    }

    public function post($uri, $action, $middleware = array())
    {
        $this->post[$uri] = $action;
        $this->middlewares('POST', $uri, $middleware);
    }

    public function put($uri, $action, $middleware = array())
    {
        $this->put[$uri] = $action;
        $this->middlewares('PUT', $uri, $middleware);
    }

    public function delete($uri, $action, $middleware = array())
    {
        $this->delete[$uri] = $action;
        $this->middlewares('DELETE', $uri, $middleware);
    }

    // Obtener parametros por post
    public function getParams($method)
    {
        if (isset($method) && !empty($method)) {
            foreach ($method as $key => $post) {
                $this->request[$key] = $post;
            }
        } else {
            $payload = file_get_contents('php://input');
            $array = json_decode($payload);
            if (isset($array)) {
                $array = get_object_vars($array);
            }
            $this->request = $array;
        }

        if (isset($_FILES)) $this->request['files'] = $_FILES;

        if (isset($this->request)) {
            $this->sanitizeRequest();
        }
    }

    // Añadir middlewares
    public function middlewares($method, $uri, $middlewares)
    {
        $this->middleware[$method][$uri] = $middlewares;
    }

    private function sanitizeRequest()
    {
        $filters = array();
        foreach ($this->request as $key => $value) {
            if ($key == 'email') {
                $filters[$key] = 'trim|escape|lowercase';
            } else {
                $filters[$key] = 'trim|escape';
            }
        }
        $sanitizer  = new Sanitizer($this->request, $filters);

        $params = $sanitizer->sanitize();

        $this->request = Utils::arrayToObject($params);
    }
}
