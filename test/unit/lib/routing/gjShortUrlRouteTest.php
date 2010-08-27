<?php
/**
 * This file is part of the gjShortUrlPlugin unit tests package.
 * (c) Christian Schaefer <schaefer.christian@guj.de>
 *
 * This class has been auto-generated by the sfPhpUnitWizardPlugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    gjShortUrlPluginUnitTests
 * @author     Christian Schaefer <schaefer.christian@guj.de>
 * @version    SVN: $Id: $
 */

/**
 * PHPUnit test for lib/routing/gjShortUrlRoute.class.php
 *
 * @package    gjShortUrlPluginUnitTests
 * @subpackage routing
 * @author     Christian Schaefer <schaefer.christian@guj.de>
 */
class gjShortUrlRouteTest extends PHPUnit_Framework_TestCase
{
  /**
   * @covers gjShortUrlRoute::getObject
   */
  public function testGetObjectBeforeAnyMatch()
  {
    $this->assertFalse($this->route->getObject());
  }

  /**
   * @covers gjShortUrlRoute::matchesUrl
   * @depends testGetObjectBeforeAnyMatch
   */
  public function testMatchesUrl()
  {
    $shortUrl = new gjShortUrl();
    $shortUrl->source = 'some-short-url';
    $shortUrl->target = '/redirected';
    $shortUrl->save();

    $url     = '/some-short-url';
    $context = array(
      'path_info'   => '/some-short-url',
      'prefix'      => '',
      'method'      => 'GET',
      'format'      => null,
      'host'        => 'localhost',
      'is_secure'   => false,
      'request_uri' => 'http://localhost/some-short-url?with=query-string'
    );
    $parameters = $this->route->matchesUrl($url, $context);
    $this->assertFalse($parameters);
  }

  /**
   * @covers gjShortUrlRoute::getObject
   * @depends testMatchesUrl
   */
  public function testGetObject()
  {
    $this->assertFalse($this->route->getObject());
  }

  protected function setUp()
  {
    global $configuration;
    $databaseManager = new sfDatabaseManager($configuration);
    $dbh = new Doctrine_Adapter_Mock('mysql');
    $conn = Doctrine_Manager::getInstance()->openConnection($dbh, 'mysql', true);
    Doctrine_Manager::getInstance()->createDatabases('doctrine');
    Doctrine_Core::createTablesFromArray(array('gjShortUrl'));

    $this->route = new gjShortUrlRoute('/:shorturl', array('module' => 'gjShortUrl', 'action' => 'redirect'));
  }
}
