<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    #[Post(
        path: '/api/email/verification-notification',
        operationId: 'resendVerificationEmail',
        description: 'Позволяет отправить повторно email для подтверждения пользователю.',
        summary: 'Отправка уведомления о подтверждении email',
        security: [['bearerAuth' => []]],
        tags: ['Auth']
    )]
    #[Response(
        response: 200,
        description: 'Уведомление отправлено.',
        content: new JsonContent(
            properties: [
                new Property(property: 'status', type: 'string', example: 'Ссылка для подтверждения отправлена'),
            ]
        )
    )]
    #[Response(
        response: 429,
        description: 'Слишком много запросов. Попробуйте позже.',
        content: new JsonContent(
            properties: [
                new Property(property: 'message', type: 'string', example: 'Слишком много запросов.'),
            ]
        )
    )]
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
