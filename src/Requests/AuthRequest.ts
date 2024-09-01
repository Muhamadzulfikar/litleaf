import {t} from "elysia";

const register = {
    body: t.Object({
        name: t.String(),
        gender: t.Enum({
            male: 'male',
            female: 'female',
        }),
        picture: t.String({
            format: "uri"
        }),
        email: t.String({
            format: "email"
        }),
        password: t.String({
            minLength: 8,
        }),
        role: t.String(),
    })
}

const login = {
    body: t.Object({
        email: t.String({
            format: "email",
        }),
        password: t.String({
            minLength: 8,
        }),
    })
}

export default {
    register,
    login
}
