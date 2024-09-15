import {Elysia, t} from "elysia";
import {PrismaClient} from "@prisma/client";
import NovelRequest from "../Requests/NovelRequest";
import AuthService from "../Services/AuthService";
import ErrorHandlingService from "../Services/ErrorHandlingService";

const prisma = new PrismaClient();

const novelRoute = new Elysia({prefix: '/api/v1/novels'})
    .get('/', async () => {
        const novels = await prisma.novel.findMany();
        return {
            status: 'success',
            data: novels,
            message: 'Successfully get novels'
        };
    })
    .get('/:id', async ({params: {id}, error}: { params: { id: string }, error: any }) => {
        const novel = await prisma.novel.findFirst({
            where: {
                uuid: id,
            }
        });

        if (!novel) {
            return error(404, 'Data not found');
        }

        return {
            status: 'success',
            data: novel,
            message: 'Successfully get novel by id'
        };
    })
    .post('/', async ({body, error, bearer}: { body: any, error: any, bearer: string }) => {
        let novel;

        try {
            const {id: userId}: any = AuthService.validateToken(bearer);
            body.user_uuid = userId;
            novel = await prisma.novel.create({data: body});
        } catch (e: any) {
            ErrorHandlingService.responseError(e);
        }

        return {
            status: 'success',
            data: novel,
            message: 'successfully create novel',
        }
    }, NovelRequest.createNovel);

export default novelRoute;
