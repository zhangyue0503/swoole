<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\View\RenderInterface;

/**
 * @AutoController()
 */
class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}. 9601",
        ];
    }

    public function view(RenderInterface $render){
        return $render->render('hello', ['name' => 'Zyblog']);
    }

    public function test2(){
        return 'This is auto Test2';
    }


}
