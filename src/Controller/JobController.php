<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JobController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, KernelInterface $kernel)
    {
        if ($request->isMethod('post')) {
            $application = new Application($kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput(array(
                'command' => 'scraper:scrape',
                // (optional) define the value of command arguments
                'url' => $request->get('url'),
            ));

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            $content = $output->fetch();

            return $this->render('job/run.html.twig', [
                'content'            => $content
            ]);
        } else {
            $dbJobs = $this->getDoctrine()->getManager()->getRepository('App:Job')->findAll();

            return $this->render('job/index.html.twig', [
                'controller_name' => 'JobController',
                'jobs'            => $dbJobs
            ]);
        }
    }
}
