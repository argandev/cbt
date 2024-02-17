import moment from 'moment-timezone'

var timeElement, eventTime, currentTime, duration, interval, intervalId;

interval = 1000; // 1 second

// get time element
timeElement = document.querySelector("time");
// calculate difference between two times
eventTime = moment.tz("2040-11-15T09:00:00", "America/Los_Angeles");
// based on time set in user's computer time / OS
currentTime = moment.tz();
// get duration between two times
duration = moment.duration(eventTime.diff(currentTime));

// loop to countdown every 1 second
setInterval(function () {
    // get updated duration
    duration = moment.duration(duration - interval, 'milliseconds');

    // if duration is >= 0
    if (duration.asSeconds() <= 0) {
        clearInterval(intervalId);
        // hide the countdown element
        timeElement.classList.add("hidden");
    } else {
        // otherwise, show the updated countdown
        timeElement.innerText = duration.years() + " years " + duration.days() + " days " + duration.hours() + " hours " + duration.minutes() + " minutes " + duration.seconds() + " seconds";
    }
}, interval);