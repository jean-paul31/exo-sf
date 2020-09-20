<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherService;
use App\Entity\OpenWeatherMapForm;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class WeatherController extends AbstractController
{
  private $weatherService;

  public function __construct(WeatherService $weather)
  {
    $this->weatherService = $weather;
  }

  /**
   * @Route("/weather", name="weather")
   */
  public function index(Request $request)
  {
    // form generation
    $city_name = new OpenWeatherMapForm();

    $form = $this->createFormBuilder($city_name)
      ->add('city_name', TextType::class, ['attr' => ['class' => 'form-control col-md-2 offset-5'],])
      ->add('save', SubmitType::class, ['label' => 'Afficher', 'attr' => ['class' => 'btn btn-primary']])
      ->getForm();
    // form validation
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $city_name = $form->getData();

      return $this->redirectToRoute('weather_city', [
        'city' => $city_name->getCityName(),
      ]);
    }
    return $this->render('weather/index.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/weather/{city}", name="weather_city")
   */
  public function number($city)
  {
    $data = $this->weatherService->getWeather($city);
    if (is_array($data)) {
      return $this->render('weather/result.html.twig', ['data' => $data]);
    } else {
      $statusCode = 0;
      $errorMessage = '';
      $e = $data;
      if (method_exists($e, 'getResponse')) {
        $statusCode = $e->getResponse()->getStatusCode();
      }
      if ($statusCode == 0) {
        $errorMessage = 'Error occurs';
      }
      if (401 == $statusCode) {
        $errorMessage = "API calls return an error 401.
          You can get the error 401";
      }
      if (404 == $statusCode) {
        $errorMessage = "API calls return an error 404.";
      }
      if (429 == $statusCode) {
        $errorMessage = "API calls return an error 429.
          You will get the error 429 if you have free tariff and make more than 60 API calls per minute.

          Please switch to a subscription plan that meets your needs or reduce the number of API calls in accordance with the established limits.";
      }
      return $this->render('errors.html.twig', ['error' => $errorMessage]);
    }
  }
}
