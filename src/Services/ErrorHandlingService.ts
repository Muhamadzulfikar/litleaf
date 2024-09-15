import {error} from "elysia";

class ErrorHandlingService {
    unauthorized(message: string): Error {
        const status = 'Unauthorized';
        const error: any = new Error(`${message}`);
        error.code = 401;
        error.status = status;
        throw error;
    }

    forbidden(message: string): Error {
        const status = 'Forbidden';
        const error: any = new Error(`${message}`);
        error.code = 403;
        error.status = status;
        throw error;
    }

    internalError(message: string): Error {
        const status = 'Internal Server Error';
        const error: any = new Error(`${message}`);
        error.code = 500;
        error.status = status;
        throw error;
    }

    badRequest(message: string): Error {
        const status = 'Bad Request';
        const error: any = new Error(`${message}`);
        error.code = 400;
        error.status = status;
        throw error;
    }

    notFound(message: string): Error {
        const status = 'Not Found';
        const error: any = new Error(`${message}`);
        error.code = 404;
        error.status = status;
        throw error;
    }

    responseError(e: any) {
        throw error(e.code, {
            status: 'Error',
            data: {},
            message: e.message,
        })
    }
}

export default new ErrorHandlingService();
