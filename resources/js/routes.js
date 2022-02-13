import BasketballCourtComponent from "./components/BasketballCourtComponent";
import BasketballCourtsComponent from "./components/BasketballCourtsComponent";
import WeatherCheckComponent from "./components/WeatherCheckComponent";
import RadiationCheckComponent from "./components/RadiationCheckComponent";
import UserSettings from "./components/user/settings/UserSettings";

const routes = [
    {
        path: '/basketball-courts/:id',
        name: 'basketball-court',
        component: BasketballCourtComponent,
    },
    {
        path: '/',
        name: 'basketball-courts',
        component: BasketballCourtsComponent,
    },
    {
        base: '/',
        path: '/weather',
        name: 'weather-check',
        component: WeatherCheckComponent,
    },
    {
        path: '/radiation-info',
        name: 'radiation-info',
        component: RadiationCheckComponent,
    },
    {
        path: '/user-settings',
        name: 'user-settings',
        component: UserSettings,
    },
];

export default routes
