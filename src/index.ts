import { Elysia } from "elysia";
import AuthController from "./Controllers/Admin/AuthController";
import NovelController from "./Controllers/Admin/NovelController";

const authController = new AuthController();
const novelController = new NovelController();

const app = new Elysia()
    .get("/", () => "Hello Elysia")
    .post("/api/v1/auth/login", authController.login)
    .post("/api/v1/auth/register", authController.register)
    .get("/api/v1/novels", novelController.getNovel())
    .listen(3000);

console.log(
  `🦊 Elysia is running at ${app.server?.hostname}:${app.server?.port}`
);
