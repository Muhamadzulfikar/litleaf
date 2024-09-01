import {PrismaClient} from "@prisma/client";

const prisma = new PrismaClient();

class AuthController
{
    async register(req: any)
    {
        const user = await prisma.user.create({ data: req.body });
        return {
            status: 'success',
            data: user,
        };
    }

    login(req: any)
    {
        return req.body
    }
}

export default AuthController
