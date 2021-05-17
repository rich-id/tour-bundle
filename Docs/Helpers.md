# Helpers

The bundle offers javascript helpers to easily use the bundle features. To use them, make sure to include the Twig template: `{{ include('@RichIdTour/helpers.html.twig') }}`

Here are the exposed Javascript functions to help you make your tour:

| Javascript function            | Description                                          |
| ---                            | ---                                                  |
| `markTourAsPerformed(tourId)` | Mark the given tour as performed for the current user |
| `isTourAvailable(tourId)`     | Check if the tour is available                        |
