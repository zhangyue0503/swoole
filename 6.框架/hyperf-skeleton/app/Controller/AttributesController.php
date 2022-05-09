<?php


namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller]
class AttributesController extends AbstractController
{
    /**
     * @RequestMapping(path="r", methods="get,post")
     */
    public function route(RequestInterface $request){
        return ['This is Attributes Route Test','params', $request->all()];
        // ["This is Attributes Route Test","params",{"a":"1","b":"2"}]
    }
}
