<?php

namespace App\IO\Http\Weather\Controller;

use App\Domain\Weather\Services\TemperatureFinder;
use App\IO\Http\Weather\Request\TemperatureDayFinderRequest;
use App\IO\Http\Weather\Response\TemperatureListResponse;
use App\IO\Http\Weather\Response\TemperatureResponse;
use Domain\Weather\Dto\TemperatureListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class HomeController
 *
 * @package App\Controller\Weather
 */
class HomeController extends AbstractController
{
    /** @var TemperatureFinder */
    private $temperatureFinder;
    
    /** @var ValidatorInterface */
    private $validator;
    
    /**
     * HomeController constructor.
     */
    public function __construct(TemperatureFinder $finder, ValidatorInterface $validator)
    {
        $this->temperatureFinder = $finder;
        $this->validator = $validator;
    }
    
    /**
     * @Route("/", methods={"GET"})
     */
    public function index()
    {
        try {
            return $this->render('weather/index.html.twig', [
                'temperatures' => new TemperatureListResponse($this->temperatureFinder->findForLastDays()),
            ]);
        } catch (\Exception $exception) {
            return $this->render('weather/error.html.twig', [
                'message' => $exception->getMessage(),
            ]);
        }
        
        
    }
    
    /**
     * @Route("/weather/temperature/find-for-date", methods={"POST"})
     */
    public function weatherTemperatureFindForDate(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $requestData = new TemperatureDayFinderRequest($request->request->all());
            $errors = $this->validator->validate($requestData);
            if (sizeof($errors) > 0) {
                return new JsonResponse([
                    'error'   => true,
                    'message' => 'Wrong params',
                    'data'    => call_user_func(static function () use ($errors) {
                        $result = [];
                        /** @var ConstraintViolationInterface $error */
                        foreach ($errors as $error) {
                            $result[] = [
                                'field'   => $error->getPropertyPath(),
                                'message' => $error->getMessage()
                            ];
                        }
                        
                        return $result;
                    })
                ], 200);
            }
            try {
                $temperature = $this->temperatureFinder->findByDate($requestData);
                return new JsonResponse([
                    'error'   => false,
                    'message' => 'success',
                    'data'    => new TemperatureResponse($temperature),
                ], 200);
                
                
            } catch (\Exception $exception) {
                //Не хорошо так конечно, но делать нормальную обработку ошибок уже лень, по идее нужно разбить на отдельные Exception
                return new JsonResponse([
                    'error'   => true,
                    'message' => $exception->getMessage(),
                    'data'    => []
                ], 200);
            }
        } else {
            return new JsonResponse([
                'error'   => true,
                'message' => 'Allowed only Ajax Requests',
                'data'    => []
            ], 200);
        }
    }
    
}
