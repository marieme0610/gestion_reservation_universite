<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Exception\IdentifiantsInvalidesException;
use App\Core\SessionManager;
use App\Rendering\ResponseRendererInterface;

class AuthController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private SessionManager $session,
        ResponseRendererInterface $renderer
    ) {
        parent::__construct($renderer);
    }

    public function showLogin(): void
    {
        $errors = $this->session->get('errors', []);
        $this->session->unset('errors');

        $this->renderView('auth/login', [
            'title'  => 'Connexion',
            'errors' => $errors,
        ]);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        try {
            $this->authService->connecter($email, $motDePasse);
            $this->redirect('/reservations');
        } catch (IdentifiantsInvalidesException $e) {
            $this->session->set('errors', ['globale' => $e->getMessage()]);
            $this->redirect('/login');
        }
    }

    public function logout(): void
    {
        $this->authService->deconnecter();
        $this->redirect('/login');
    }
}