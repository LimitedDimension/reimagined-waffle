export const usdMaskValueCheck = (value, digits = 2) => {
    const mask = new RegExp(/^((0|[1-9][0-9]{0,2})(,\d{0,3})*(\.\d{0,2})?)?$/);

    return mask.test(value);
};
