<?php
namespace app\controllers\api;

use app\core\Controller;
use app\facade\App;
use app\requests\config\ConfigRequest;
use app\services\Config\ConfigService;
use app\services\Request;
use app\services\Response;

class ConfigController extends Controller{

    public function __construct(private ConfigService $configService)
    {
        
    }

    public function index(Request $request):Response{
        
        $validated = $request->post()->validate(ConfigRequest::class);
        
        if($validated['error']){
            return new Response(
                json_encode([
                    'error' => true,
                    'message' => 'Verifique os dados e tente novamente.',
                    'issues' => $validated['issues']
                ])
            );
        }        

        $data = $validated['issues'];

        $data['id'] = App::session()->__get('config')->id;
        

        $response = $this->configService->put($data);

        App::session()->__set("config", $response->data);

        return new Response(
            json_encode($response)
        );
    }

}