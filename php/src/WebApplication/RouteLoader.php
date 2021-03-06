<?php

namespace WebApplication;

use Silex\Application as BaseApplication;

class RouteLoader
{
    private $app;

    public function __construct(BaseApplication $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    private function instantiateControllers()
    {
        $this->app['static.controller'] = $this->app->share(function () {
            return new Controller\StaticController();
        });

        $this->app['statistics.controller'] = $this->app->share(function () {
            return new Controller\StatisticsController();
        });

        $this->app['list.controller'] = $this->app->share(function () {
            return new Controller\ListController();
        });

        $this->app['person.controller'] = $this->app->share(function () {
            return new Controller\PersonController();
        });

        $this->app['publication.controller'] = $this->app->share(function () {
            return new Controller\PublicationController();
        });

        $this->app['place.controller'] = $this->app->share(function () {
            return new Controller\PlaceController();
        });
    }

    public function bindRoutesToControllers()
    {
        $this->app->get('/', array($this->app['static.controller'], 'homeAction'))
            ->bind('home');

        $this->app->get('/geschichten', array($this->app['static.controller'], 'geschichtenAction'))
            ->bind('geschichten');

        $this->app->get('/analyse', array($this->app['statistics.controller'], 'introAction'))
            ->bind('analyse');

        $this->app->get('/analyse-jahr', array($this->app['statistics.controller'],
                                               'yearAction'))
            ->bind('analyse-jahr');

        $this->app->get('/analyse-worte', array($this->app['statistics.controller'],
                                               'wordCountAction'))
            ->bind('analyse-worte');

        $this->app->get('/analyse-orte', array($this->app['statistics.controller'],
                                               'placeCountAction'))
            ->bind('analyse-orte');
        $this->app->get('/analyse-karte-publikationsorte',
                        array($this->app['static.controller'],
                              'tableauPublikationsOrteAction'))
            ->bind('analyse-karte-publikationsorte');
        $this->app->get('/analyse-visualisierung-dot',
                        array($this->app['static.controller'],
                              'tableauDotAction'))
            ->bind('analyse-visualisierung-dot');
        $this->app->get('/analyse-visualisierung-bubble',
                        array($this->app['static.controller'],
                              'tableauBubbleAction'))
            ->bind('analyse-visualisierung-bubble');
        $this->app->get('/analyse-karte-publikationslaender',
                        array($this->app['statistics.controller'],
                              'leafletOrtAction'))
            ->bind('analyse-karte-publikationslaender');
        $this->app->get('/analyse-orte-geburttod',
                        array($this->app['statistics.controller'],
                              'd3jsOrtAction'))
            ->bind('analyse-orte-geburttod');
        $this->app->get('/analyse-personen-wikipedia',
                        array($this->app['statistics.controller'],
                              'personenWikipediaAction'))
            ->bind('analyse-personen-wikipedia');

        // list
        $this->app->get('/list', array($this->app['list.controller'], 'indexAction'))
            ->bind('list');
        $this->app->post('/list', array($this->app['list.controller'], 'indexAction'));

        $this->app->get('/list/{row}', array($this->app['list.controller'], 'detailAction'))
            ->assert('row', '\d+')
            ->bind('list-detail');

        $this->app->get('/list/{row}/edit',
                        array($this->app['list.controller'], 'editAction'))
            ->bind('list-edit');
        $this->app->post('/list/{row}/edit',
                         array($this->app['list.controller'], 'editAction'));

        // person
        $this->app->get('/person', array($this->app['person.controller'], 'indexAction'))
            ->bind('person');
        $this->app->post('/person', array($this->app['person.controller'], 'indexAction'));
        $this->app->get('/person/beacon', array($this->app['person.controller'], 'gndBeaconAction'));

        $this->app->get('/person/{id}',
                        array($this->app['person.controller'], 'detailAction'))
            ->bind('person-detail');
        $this->app->get('/person/gnd/{gnd}',
                        array($this->app['person.controller'], 'detailAction'))
            ->bind('person-detail-gnd');

        $this->app->get('/person/{id}/edit',
                        array($this->app['person.controller'], 'editAction'))
            ->bind('person-edit');
        $this->app->post('/person/{id}/edit',
                         array($this->app['person.controller'], 'editAction'));

        // publication
        $this->app->get('/publication', array($this->app['publication.controller'], 'indexAction'))
            ->bind('publication');
        $this->app->post('/publication', array($this->app['publication.controller'], 'indexAction'));
        $this->app->get('/publication/{id}',
                        array($this->app['publication.controller'], 'detailAction'))
            ->bind('publication-detail');


        // place
        $this->app->get('/place', array($this->app['place.controller'], 'indexAction'))
            ->bind('place');
        $this->app->post('/place', array($this->app['place.controller'], 'indexAction'));
        // $this->app->get('/person/beacon', array($this->app['person.controller'], 'gndBeaconAction'));

        $this->app->get('/place/{id}', array($this->app['place.controller'], 'detailAction'))
            ->assert('id', '\d+')
            ->bind('place-detail');

        $this->app->get('/place/{id}/edit',
                        array($this->app['place.controller'], 'editAction'))
            ->bind('list-edit');
        $this->app->post('/place/{id}/edit',
                         array($this->app['place.controller'], 'editAction'));

        // about
        $this->app->get('/about', array($this->app['static.controller'], 'aboutAction'))
            ->bind('about');
    }
}
