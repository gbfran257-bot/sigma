/**
 * It returns current date formatted to its use
 * @returns { String }
 */
const generatePrintingDate = () => {
    const currentDate = new Date();
    return `${currentDate.getDate()}-${currentDate.getMonth() + 1}-${currentDate.getFullYear()} ${currentDate.getHours()}:${currentDate.getMinutes()}:${currentDate.getSeconds()}`;
};