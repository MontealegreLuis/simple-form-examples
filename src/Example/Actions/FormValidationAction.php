<?php
/**
 * PHP version 5.5
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace Example\Actions;

use Application\Actions\ProvidesFormRenderer;
use EasyForms\Bridges\Zend\InputFilter\InputFilterValidator;
use Example\Forms\SignUpForm;
use Slim\Http\Request;
use Twig_Environment as Twig;

class FormValidationAction
{
    use ProvidesFormRenderer;

    /** @var SignUpForm */
    protected $signUpForm;

    /** @var InputFilterValidator */
    protected $signUpValidator;

    /**
     * @param Twig $view
     * @param SignUpForm $signUpForm
     * @param InputFilterValidator $signUpValidator
     */
    public function __construct(Twig $view, SignUpForm $signUpForm, InputFilterValidator $signUpValidator)
    {
        $this->view = $view;
        $this->signUpForm = $signUpForm;
        $this->signUpValidator = $signUpValidator;
    }

    /**
     * Validate the form values and show it with the corresponding error messages
     *
     * If a file is sent it si saved in the 'uploads' folder
     *
     * @param Request $request
     */
    public function validate(Request $request)
    {
        $this->configureFormRenderer('optional');

        $signUpInformation = $request->isGet() ? [] : array_merge($request->post(), $_FILES);

        $this->signUpForm->submit($signUpInformation);

        $isValid = $this->signUpValidator->validate($this->signUpForm);

        echo $this->view->render('examples/validation.html.twig', [
            'signUp' => $this->signUpForm->buildView(),
            'isValid' => $isValid,
        ]);
    }
}
