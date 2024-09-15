import { Elysia, t } from "elysia";
import { cors } from '@elysiajs/cors'
import AuthRoute from "./routes/AuthRoute";
import NovelRoute from "./routes/NovelRoute";
import { swagger } from '@elysiajs/swagger'

const app = new Elysia()
    .use(cors())
    .use(swagger())
    .derive(({ headers }) => {
        const auth = headers.authorization

        return {
            bearer: auth?.startsWith('Bearer ') ? auth.slice(7) : null
        }
    })
    .use(AuthRoute)
    .use(NovelRoute)
    .onError(({ code }) => {
        if (code === 'NOT_FOUND')
            return 'Route not found :('
    })
    .listen(3000);

console.log(
  `🦊 Elysia is running at ${app.server?.hostname}:${app.server?.port}`
);
