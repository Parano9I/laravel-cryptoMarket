const middlewarePipeline = (context, middleware, index) => {
    if (!middleware[index]) return context.next;

    const nextMiddleware = middleware[index];

    return (...parameters) => {
        context.next(...parameters);
        const nextPipeline = middlewarePipeline(context, middleware, index + 1);
        nextMiddleware({...context, next:nextPipeline});
    }
};

export default middlewarePipeline;
