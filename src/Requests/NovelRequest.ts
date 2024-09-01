import {t} from "elysia";

const createNovel = {
    body: t.Object({
        user_uuid: t.String({
            format: "uuid",
        }),
        name: t.String(),
        description: t.String(),
        cover: t.String({
            format: "uri"
        }),
        is_publish: t.Boolean(),
    })
}

export default {
    createNovel
}
