import {PrismaClient} from "@prisma/client";

const prisma = new PrismaClient();

class NovelController
{
    async getNovel({ error }: {error : any})
    {
        const novels = await prisma.novel.findMany();
        return {
            status: 'success',
            data: novels,
            message: 'Successfully get novels'
        };
    }

    async getNovelById({ params: {id}, error }: {params: {id: string}, error: any})
    {
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
    }

    async CreateNovel({req: { body } }: {req: {body : any} })
    {
        const novel = await prisma.novel.create({ data: body })
        return {
            status: 'success',
            data: novel,
            message: 'successfully create novel',
        }
    }
}

export default new NovelController()
