import {PrismaClient} from "@prisma/client";

class NovelController
{
    getNovel()
    {
        return {
            status: 'success',
            data: [],
        };
    }
}

export default NovelController
