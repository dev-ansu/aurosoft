<?php
namespace app\controllers\api;

use app\core\Controller;
use app\facade\App;
use app\requests\config\ConfigRequest;
use app\services\Config\ConfigService;
use app\core\Request;
use app\core\Response;

class ConfigController extends Controller{

    public function __construct(private ConfigService $configService)
    {
        
    }

    public function index(Request $request, Response $res){
        
        $validated = $request->post()->validate(ConfigRequest::class);
        
        if($validated['error']){
            return $res->json([
                'error' => true,
                'message' => 'Verifique os dados e tente novamente.',
                'issues' => $validated['issues']
            ]);
        }        

        $data = $validated['issues'];

        $data['id'] = App::session()->__get('config')->id;
        

        $response = $this->configService->put($data);

        App::session()->__set("config", $response->data);

        return $res->json($response->toArray());

    }

}