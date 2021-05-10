# Helpers

The bundle offers javascript helpers to easily use the bundle functionality. You just have to include in your page the html block `{{ include('@RichIdTour/helpers.html.twig') }}`


Here are the functions:

- savedPerformedTourForCurrentUser(tourId): save in database for the connected user, that the visit `tourId` has been seen
- savedPerformedTourInCookie(tourId, duration): save in cookie that the visit `tourId` has been seen (if you do not specify a duration, the cookie will expire in 6 months)
- savedPerformedTourInLocalStorage(tourId): save in local storage that the visit `tourId` has been seen

- hasPerformedTourInCookie(tourId): allows to know if the visit `tourId` has been seen (saved in cookie)
- hasPerformedTourInLocalStorage(tourId): allows to know if the visit `tourId` has been seen (saved in local storage)

To find out if the connected user should see the visit (he has not already seen it and the visit is not disabled), you can use the twig function hasAccessToTour()
