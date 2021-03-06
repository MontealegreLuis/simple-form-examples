<?php
/**
 * PHP version 5.5
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace Example\Actions;

use Application\Actions\ProvidesFormRenderer;
use Example\Forms\SignUpForm;
use Twig_Environment as Twig;

class ShowElementTypesAction
{
    use ProvidesFormRenderer;

    /** @var SignUpForm */
    protected $signUpForm;

    /**
     * @param Twig $view
     * @param SignUpForm $signUpForm
     */
    public function __construct(Twig $view, SignUpForm $signUpForm)
    {
        $this->view = $view;
        $this->signUpForm = $signUpForm;
    }

    /**
     * Show a form with all the available form elements
     */
    public function showTypes()
    {
        $this->configureFormRenderer('optional');

        echo $this->view->render('examples/form-elements.html.twig', [
            'signUp' => $this->signUpForm->buildView(),
        ]);
    }
}
