import {PrismaClient} from "@prisma/client";
import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';

const prisma = new PrismaClient();

class AuthController {
    async register({body, error}: { body: any, error: any }) {
        body.password = await bcrypt.hash(body.password, 10);
        let user;

        try {
            user = await prisma.user.create({data: body})
        } catch (e: any) {
            return error(e.status, e.message);
        }

        return {
            status: 'success',
            data: user,
            message: 'Successfully register new user',
        };
    }

    async login({body, error}: {body: any, error: any}) {
        const user: any = await prisma.user.findFirst({
            where: {
                email: body.email
            },
        });

        if (!user) {
            error(401, 'User account not found');
        }

        const isPassword = await bcrypt.compare(body.password, user.password);

        if (!isPassword) {
            error(401, 'Password not match');
        }

        const jwtSignatureKey: any = process.env.JWT_SIGNATURE_KEY;
        user.token = await jwt.sign({id: user.uuid}, jwtSignatureKey, { expiresIn: '1d' })

        return {
            status: 'success',
            data: user,
            message: 'Successfully login'
        };
    }
}

export default new AuthController();
