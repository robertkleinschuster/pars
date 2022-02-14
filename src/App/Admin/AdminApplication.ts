import "./AdminApplication.scss";
import "./Navigation/NavigationComponent";
import ViewEventHandler from "../../Core/View/ViewEventHandler";
import OverviewComponent from "./Overview/OverviewComponent";

export default class AdminApplication {
    public run()
    {
        document.querySelectorAll('.component').forEach( (component: HTMLElement) => {
            const eventHandler = new ViewEventHandler(new URL(document.location.href, document.baseURI), component);
            eventHandler.init();
        });

        const overview = new OverviewComponent();
    }
}

const app = new AdminApplication();
app.run();
