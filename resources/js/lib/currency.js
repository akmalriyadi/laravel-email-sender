const locale = 'id-ID'
const initSaldo = (value, currency = false) => {
    let current = 'decimal'
    // if (currency) {
    //     current = 'currency'
    // } else {
    //     current = 'decimal'
    // }
    const floatValue = parseFloat(value);
    const roundedValue = Math.floor(floatValue);
    const formatSaldo = new Intl.NumberFormat(locale, {
        style: current,
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(roundedValue);

    const newFormat = formatSaldo.replace(/\,00$/, '').replace(/\./g, ',');
    if (currency) {
        return `Rp. ${newFormat}`
    } else {
        return newFormat
    }
};

export default initSaldo
