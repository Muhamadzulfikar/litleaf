import {t} from "elysia";

const createNovel = {
    body: t.Object({
        name: t.String(),
        description: t.String(),
        cover: t.String({
            format: "uri"
        }),
        is_publish: t.Boolean(),
        is_private: t.Optional(t.Boolean()),
        age: t.Optional(t.Number({
            minimum: 10,
        }))
    })
}

export default {
    createNovel
}
