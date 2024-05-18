import moment from 'moment-timezone';

function formatToWIB(isoTime) {
    const indonesiaTime = moment(isoTime).tz('Asia/Jakarta');
    return indonesiaTime.format('YYYY-MM-DD');
}

function formatWithTime(isoTime) {
    const indonesiaTime = moment(isoTime).tz('Asia/Jakarta');
    return indonesiaTime.format('YYYY-MM-DD HH:mm:ss');
}

export { formatToWIB, formatWithTime }
