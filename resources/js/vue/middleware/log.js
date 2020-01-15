// src/middleware/log.js
export default function log({ next, to }) {
    // console.log(to.name);
    return next();
}
