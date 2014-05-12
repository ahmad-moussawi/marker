<?php

class PartialsController extends BaseController {

    /**
     * Cache time in minutes
     * @var int 
     */
    protected $cache = 1;

    public function StaticView($viewName) {
        return View::make("layouts.static.$viewName");
    }

    public function ModuleView($viewName, $entityId) {

        $cacheKey = "view_{$viewName}_{$entityId}";


        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            $entity = Entity::filterByIdOrTitle($entityId)->first();
            
            if ($entity === null) {
                $result = View::make("admin.modules.notfound", array('viewName' => $viewName, 'entityId' => $entityId));
            } else {
                $result = View::make("admin.modules.$viewName", array(
                            'entity' => $entity
                ));
            }

            Cache::put($cacheKey, $result->render(), $this->cache);
            return $result;
        }
    }

}
