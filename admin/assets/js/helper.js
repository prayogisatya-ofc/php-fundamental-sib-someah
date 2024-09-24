// helper mengubah text menjadi slug
const slugify = (text) => {
    return text.trim()
        .toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/-+/g, '-');
}