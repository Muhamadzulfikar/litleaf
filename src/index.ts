import { Elysia, t } from "elysia";
import AuthController from "./Controllers/AuthController";
import NovelController from "./Controllers/NovelController";
import AuthRequest from "./Requests/AuthRequest";
import NovelRequest from "./Requests/NovelRequest";
import { cors } from '@elysiajs/cors'

const app = new Elysia()
    .use(cors())
    .post("/api/v1/auth/login", AuthController.login, AuthRequest.login)
    .post("/api/v1/auth/register", AuthController.register, AuthRequest.register)

    .get("/api/v1/novels", NovelController.getNovel)
    .get("/api/v1/novels/:id", NovelController.getNovelById)
    .post("/api/v1/novels",  NovelController.CreateNovel, NovelRequest.createNovel)

    .onError(({ code }) => {
        if (code === 'NOT_FOUND')
            return 'Route not found :('
    })
    .listen(3000);

console.log(
  `🦊 Elysia is running at ${app.server?.hostname}:${app.server?.port}`
);
