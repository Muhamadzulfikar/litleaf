import jwt from "jsonwebtoken";
import ErrorHandlingService from "./ErrorHandlingService";

class AuthService
{
    validateToken(token: string)
    {
        if (token === null) {
            ErrorHandlingService.badRequest('Token must not be empty');
        }
         const jwtSignatureKey: any = process.env.JWT_SIGNATURE_KEY;
         return jwt.verify(token, jwtSignatureKey);
    }
}

export default new AuthService();
