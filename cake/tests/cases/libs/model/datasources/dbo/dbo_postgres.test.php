<?php
/**
 * DboPostgresTest file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs
 * @since         CakePHP(tm) v 1.2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Core', array('Model', 'DataSource', 'DboSource', 'DboPostgres'));
App::import('Model', 'App');
require_once dirname(dirname(dirname(__FILE__))) . DS . 'models.php';

/**
 * DboPostgresTestDb class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class DboPostgresTestDb extends DboPostgres {

/**
 * simulated property
 *
 * @var array
 * @access public
 */
	var $simulated = array();

/**
 * execute method
 *
 * @param mixed $sql
 * @access protected
 * @return void
 */
	function _execute($sql) {
		$this->simulated[] = $sql;
		return null;
	}

/**
 * getLastQuery method
 *
 * @access public
 * @return void
 */
	function getLastQuery() {
		return $this->simulated[count($this->simulated) - 1];
	}
}

/**
 * PostgresTestModel class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class PostgresTestModel extends Model {

/**
 * name property
 *
 * @var string 'PostgresTestModel'
 * @access public
 */
	var $name = 'PostgresTestModel';

/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'PostgresClientTestModel' => array(
			'foreignKey' => 'client_id'
		)
	);

/**
 * find method
 *
 * @param mixed $conditions
 * @param mixed $fields
 * @param mixed $order
 * @param mixed $recursive
 * @access public
 * @return void
 */
	function find($conditions = null, $fields = null, $order = null, $recursive = null) {
		return $conditions;
	}

/**
 * findAll method
 *
 * @param mixed $conditions
 * @param mixed $fields
 * @param mixed $order
 * @param mixed $recursive
 * @access public
 * @return void
 */
	function findAll($conditions = null, $fields = null, $order = null, $recursive = null) {
		return $conditions;
	}

/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		return array(
			'id'		=> array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
			'client_id' => array('type' => 'integer', 'null' => '', 'default' => '0', 'length' => '11'),
			'name'		=> array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
			'login'		=> array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
			'passwd'	=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '255'),
			'addr_1'	=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '255'),
			'addr_2'	=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '25'),
			'zip_code'	=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			'city'		=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			'country'	=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			'phone'		=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			'fax'		=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			'url'		=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '255'),
			'email'		=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			'comments'	=> array('type' => 'text', 'null' => '1', 'default' => '', 'length' => ''),
			'last_login'=> array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => ''),
			'created'	=> array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
			'updated'	=> array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
		);
	}
}

/**
 * PostgresClientTestModel class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class PostgresClientTestModel extends Model {

/**
 * name property
 *
 * @var string 'PostgresClientTestModel'
 * @access public
 */
	var $name = 'PostgresClientTestModel';

/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;

/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		return array(
			'id'		=> array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8', 'key' => 'primary'),
			'name'		=> array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
			'email'		=> array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			'created'	=> array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => ''),
			'updated'	=> array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
		);
	}
}

/**
 * DboPostgresTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources.dbo
 */
class DboPostgresTest extends CakeTestCase {

/**
 * Do not automatically load fixtures for each test, they will be loaded manually
 * using CakeTestCase::loadFixtures
 *
 * @var boolean
 * @access public
 */
	var $autoFixtures = false;

/**
 * Fixtures
 *
 * @var object
 * @access public
 */
	var $fixtures = array('core.user', 'core.binary_test', 'core.comment', 'core.article',
		'core.tag', 'core.articles_tag', 'core.attachment', 'core.person', 'core.post', 'core.author',
	);
/**
 * Actual DB connection used in testing
 *
 * @var DboSource
 * @access public
 */
	var $db = null;

/**
 * Simulated DB connection used in testing
 *
 * @var DboSource
 * @access public
 */
	var $db2 = null;

/**
 * Skip if cannot connect to postgres
 *
 * @access public
 */
	function skip() {
		$this->_initDb();
		$this->skipUnless($this->db->config['driver'] == 'postgres', '%s PostgreSQL connection not available');
	}

/**
 * Set up test suite database connection
 *
 * @access public
 */
	function startTest() {
		$this->_initDb();
	}

/**
 * Sets up a Dbo class instance for testing
 *
 * @access public
 */
	function setUp() {
		Configure::write('Cache.disable', true);
		$this->startTest();
		$this->db =& ConnectionManager::getDataSource('test_suite');
		$this->db2 = new DboPostgresTestDb($this->db->config, false);
		$this->model = new PostgresTestModel();
	}

/**
 * Sets up a Dbo class instance for testing
 *
 * @access public
 */
	function tearDown() {
		Configure::write('Cache.disable', false);
		unset($this->db2);
	}

/**
 * Test field quoting method
 *
 * @access public
 */
	function testFieldQuoting() {
		$fields = array(
			'"PostgresTestModel"."id" AS "PostgresTestModel__id"',
			'"PostgresTestModel"."client_id" AS "PostgresTestModel__client_id"',
			'"PostgresTestModel"."name" AS "PostgresTestModel__name"',
			'"PostgresTestModel"."login" AS "PostgresTestModel__login"',
			'"PostgresTestModel"."passwd" AS "PostgresTestModel__passwd"',
			'"PostgresTestModel"."addr_1" AS "PostgresTestModel__addr_1"',
			'"PostgresTestModel"."addr_2" AS "PostgresTestModel__addr_2"',
			'"PostgresTestModel"."zip_code" AS "PostgresTestModel__zip_code"',
			'"PostgresTestModel"."city" AS "PostgresTestModel__city"',
			'"PostgresTestModel"."country" AS "PostgresTestModel__country"',
			'"PostgresTestModel"."phone" AS "PostgresTestModel__phone"',
			'"PostgresTestModel"."fax" AS "PostgresTestModel__fax"',
			'"PostgresTestModel"."url" AS "PostgresTestModel__url"',
			'"PostgresTestModel"."email" AS "PostgresTestModel__email"',
			'"PostgresTestModel"."comments" AS "PostgresTestModel__comments"',
			'"PostgresTestModel"."last_login" AS "PostgresTestModel__last_login"',
			'"PostgresTestModel"."created" AS "PostgresTestModel__created"',
			'"PostgresTestModel"."updated" AS "PostgresTestModel__updated"'
		);

		$result = $this->db->fields($this->model);
		$expected = $fields;
		$this->assertEqual($result, $expected);

		$result = $this->db->fields($this->model, null, 'PostgresTestModel.*');
		$expected = $fields;
		$this->assertEqual($result, $expected);

		$result = $this->db->fields($this->model, null, array('*', 'AnotherModel.id', 'AnotherModel.name'));
		$expected = array_merge($fields, array(
			'"AnotherModel"."id" AS "AnotherModel__id"',
			'"AnotherModel"."name" AS "AnotherModel__name"'));
		$this->assertEqual($result, $expected);

		$result = $this->db->fields($this->model, null, array('*', 'PostgresClientTestModel.*'));
		$expected = array_merge($fields, array(
			'"PostgresClientTestModel"."id" AS "PostgresClientTestModel__id"',
    		'"PostgresClientTestModel"."name" AS "PostgresClientTestModel__name"',
    		'"PostgresClientTestModel"."email" AS "PostgresClientTestModel__email"',
    		'"PostgresClientTestModel"."created" AS "PostgresClientTestModel__created"',
    		'"PostgresClientTestModel"."updated" AS "PostgresClientTestModel__updated"'));
		$this->assertEqual($result, $expected);
	}

/**
 * testColumnParsing method
 *
 * @access public
 * @return void
 */
	function testColumnParsing() {
		$this->assertEqual($this->db2->column('text'), 'text');
		$this->assertEqual($this->db2->column('date'), 'date');
		$this->assertEqual($this->db2->column('boolean'), 'boolean');
		$this->assertEqual($this->db2->column('character varying'), 'string');
		$this->assertEqual($this->db2->column('time without time zone'), 'time');
		$this->assertEqual($this->db2->column('timestamp without time zone'), 'datetime');
	}

/**
 * testValueQuoting method
 *
 * @access public
 * @return void
 */
	function testValueQuoting() {
		$this->assertIdentical($this->db2->value(1.2, 'float'), "'1.200000'");
		$this->assertEqual($this->db2->value('1,2', 'float'), "'1,2'");

		$this->assertEqual($this->db2->value('0', 'integer'), "'0'");
		$this->assertEqual($this->db2->value('', 'integer'), 'NULL');
		$this->assertEqual($this->db2->value('', 'float'), 'NULL');
		$this->assertEqual($this->db2->value('', 'integer', false), "DEFAULT");
		$this->assertEqual($this->db2->value('', 'float', false), "DEFAULT");
		$this->assertEqual($this->db2->value('0.0', 'float'), "'0.0'");

		$this->assertEqual($this->db2->value('t', 'boolean'), "TRUE");
		$this->assertEqual($this->db2->value('f', 'boolean'), "FALSE");
		$this->assertEqual($this->db2->value(true), "TRUE");
		$this->assertEqual($this->db2->value(false), "FALSE");
		$this->assertEqual($this->db2->value('t'), "'t'");
		$this->assertEqual($this->db2->value('f'), "'f'");
		$this->assertEqual($this->db2->value('true', 'boolean'), 'TRUE');
		$this->assertEqual($this->db2->value('false', 'boolean'), 'FALSE');
		$this->assertEqual($this->db2->value('', 'boolean'), 'FALSE');
		$this->assertEqual($this->db2->value(0, 'boolean'), 'FALSE');
		$this->assertEqual($this->db2->value(1, 'boolean'), 'TRUE');
		$this->assertEqual($this->db2->value('1', 'boolean'), 'TRUE');
		$this->assertEqual($this->db2->value(null, 'boolean'), "NULL");
		$this->assertEqual($this->db2->value(array()), "NULL");
	}

/**
 * test that localized floats don't cause trouble.
 *
 * @return void
 */
	function testLocalizedFloats() {
		$restore = setlocale(LC_ALL, null);
		setlocale(LC_ALL, 'de_DE');

		$result = $this->db->value(3.141593, 'float');
		$this->assertEqual((string)$result, "'3.141593'");

		$result = $this->db->value(3.14);
		$this->assertEqual((string)$result, "'3.140000'");

		setlocale(LC_ALL, $restore);
	}

/**
 * test that date and time columns do not generate errors with null and nullish values.
 *
 * @return void
 */
	function testDateAndTimeAsNull() {
		$this->assertEqual($this->db2->value(null, 'date'), 'NULL');
		$this->assertEqual($this->db2->value('', 'date'), 'NULL');

		$this->assertEqual($this->db2->value('', 'datetime'), 'NULL');
		$this->assertEqual($this->db2->value(null, 'datetime'), 'NULL');

		$this->assertEqual($this->db2->value('', 'timestamp'), 'NULL');
		$this->assertEqual($this->db2->value(null, 'timestamp'), 'NULL');

		$this->assertEqual($this->db2->value('', 'time'), 'NULL');
		$this->assertEqual($this->db2->value(null, 'time'), 'NULL');
	}

/**
 * Tests that different Postgres boolean 'flavors' are properly returned as native PHP booleans
 *
 * @access public
 * @return void
 */
	function testBooleanNormalization() {
		$this->assertTrue($this->db2->boolean('t'));
		$this->assertTrue($this->db2->boolean('true'));
		$this->assertTrue($this->db2->boolean('TRUE'));
		$this->assertTrue($this->db2->boolean(true));
		$this->assertTrue($this->db2->boolean(1));
		$this->assertTrue($this->db2->boolean(" "));

		$this->assertFalse($this->db2->boolean('f'));
		$this->assertFalse($this->db2->boolean('false'));
		$this->assertFalse($this->db2->boolean('FALSE'));
		$this->assertFalse($this->db2->boolean(false));
		$this->assertFalse($this->db2->boolean(0));
		$this->assertFalse($this->db2->boolean(''));
	}

/**
 * testLastInsertIdMultipleInsert method
 *
 * @access public
 * @return void
 */
	function testLastInsertIdMultipleInsert() {
		$db1 = ConnectionManager::getDataSource('test_suite');

		if (PHP5) {
			$db2 = clone $db1;
		} else {
			$db2 = $db1;
		}

		$db2->connect();
		$this->assertNotEqual($db1->connection, $db2->connection);

		$table = $db1->fullTableName('users', false);
		$password = '5f4dcc3b5aa765d61d8327deb882cf99';
		$db1->execute(
			"INSERT INTO {$table} (\"user\", password) VALUES ('mariano', '{$password}')"
		);
		$db2->execute("INSERT INTO {$table} (\"user\", password) VALUES ('hoge', '{$password}')");
		$this->assertEqual($db1->lastInsertId($table), 1);
		$this->assertEqual($db2->lastInsertId($table), 2);
	}

/**
 * Tests that table lists and descriptions are scoped to the proper Postgres schema
 *
 * @access public
 * @return void
 */
	function testSchemaScoping() {
		$db1 =& ConnectionManager::getDataSource('test_suite');
		$db1->cacheSources = false;
		$db1->reconnect(array('persistent' => false));
		$db1->query('CREATE SCHEMA _scope_test');

		$db2 =& ConnectionManager::create(
			'test_suite_2',
			array_merge($db1->config, array('driver' => 'postgres', 'schema' => '_scope_test'))
		);
		$db2->cacheSources = false;

		$db2->query('DROP SCHEMA _scope_test');
	}

/**
 * Tests that column types without default lengths in $columns do not have length values
 * applied when generating schemas.
 *
 * @access public
 * @return void
 */
	function testColumnUseLength() {
		$result = array('name' => 'foo', 'type' => 'string', 'length' => 100, 'default' => 'FOO');
		$expected = '"foo" varchar(100) DEFAULT \'FOO\'';
		$this->assertEqual($this->db->buildColumn($result), $expected);

		$result = array('name' => 'foo', 'type' => 'text', 'length' => 100, 'default' => 'FOO');
		$expected = '"foo" text DEFAULT \'FOO\'';
		$this->assertEqual($this->db->buildColumn($result), $expected);
	}

/**
 * Tests that binary data is escaped/unescaped properly on reads and writes
 *
 * @access public
 * @return void
 */
	function testBinaryDataIntegrity() {
		$data = '%PDF-1.3
		%?????????????????????????
		4 0 obj
		<< /Length 5 0 R /Filter /FlateDecode >>
		stream
		x??YM?????????????W??%)n??0??????-????]Q"??X?????????Ip	-	P V,]??#c???????ut????????Ti9 ??=????????_??4>??????????pc????Px????2q\'
		1U??bU???????+???????[?????????o"R???"HiG???????(????????^????sm?Yl????????????????E??B&????????7b??^??m???????2????s??????u#??U?????????g?????C;??")n})J??I??3??Sn???????????D????????Msx1????G????????????>??yS??uf?????????U?????????6???????C=??K??????s
		????????:-???????7?????F??????????????????V???>??l???????d????QdI?????B%W????????n~hv??CS>??????(????K!?????zB!???
		[????"???? ??iH??[????????????????L,????AlS?????=????????c??r&????:?????????????4????????]vc???b????????=siXe4/??p]??]????I??????????????_?????G???7	??????????K4??IpV???????\'????????????>??
		;???s??!2?????F???/f???j??
		dw"I??????<??????%IG1yt??D???Xg|????a????}C??????e??G??????j??m~??/???h??<#-?????????e87???t????6w}??{??
		m????????	????? 6???\
		rA??B??Z3a?????r$G??$??0??????UY4???????%C?????2rc<I??-c??.
		[??????FA????????+QglM????????????|????#x7????MgV??-GG???????I?????????Lzw???pH???????nefqC??.n??e?????????y????fb???????H??A????Nq=??@	???cQd????A??Iq??????+2&???  ????.g?????????3EP??Oi??????:>??C????
		=??ec=??R?????e??=<V$????+x+????????<??eW??????????????d??&????f??]fPA????t??n?????????????????@??????K??????}a_CI????y??Hg,??SSV??B??l4??L.??Y?????,2?????????.$????C????*?????y
		???G,_???????????=^Vkvo????{????2??????????o????D-?????????????cV??\'???G~\'p??%*????????
		????nh????O^????????[??????????f??????????F!E??(?????T6`??t????0????rT??`??????
		]?????p??)=????0?????V??m?????????~?????????b*fc??????????????}???t??s???Y?????a????X???~<??????v??1???p??TD??????????????h??*???????e)K???p????J3???????>??uN???????????????????9i??0??AAE?? ??`?????\'??ce???????X?????????1SK{qd??"t??[wQ#S??Be???????????????V`B"????????!??_???????-??*????????0??e?????????+HFj??????zvH??N|??L??????3????$z%s?????p????V38??s	??o???????3???<9B??????~??3)??x??????C???????????=????S??S;???~??????TEp???????????u??DH??$????????j??????"?????ONM??R????Rr{??S	????????op??W;??U?? P???k???????T?????????????????C????[??????H??????h??"??bF???%h????4x????(??2??????M])??d|=f??-cI0??L??k????k???R????????W??8mO3???&???????X??H???????]yF2?????????d??????????????????????7m??HAS?????.;??x(1} _kd??.???d??48M\'??????Cp^Kr??<?????X??????l!??$N<?????B??G]??????????>????b???????????:??O<j????????%???????>@??$p??u???????-QqV???V???J????q??X8(l????@zg??}Fe<?????S????????????6???L???O??~?? ??????e??????Y????=??=??D??u*GvBk;)L??N????:fl????????????q?????m???????????????"???????:?????i^????!)W?????y?????? ?????R????????c?????????s???r????????Pd????h????HV??5????????F?????????u????/M=g????????G??1co??u???????z??. ?????7????????,?????H????????????7e	??????????????????NWK?????Y?????????;????gV-???>??t????????N2 ????BaP-)eW.????t^???1???C??????L???&???5???4jv???????Z	??+4%????0l???????^??????????i??????????????????????????????????d???????19rQ=??|?????rM????;?????Y?????9.????????V?????????,+????j*????/';

		$model =& new AppModel(array('name' => 'BinaryTest', 'ds' => 'test_suite'));
		$model->save(compact('data'));

		$result = $model->find('first');
		$this->assertEqual($result['BinaryTest']['data'], $data);
	}

/**
 * Tests the syntax of generated schema indexes
 *
 * @access public
 * @return void
 */
	function testSchemaIndexSyntax() {
		$schema = new CakeSchema();
		$schema->tables = array('i18n' => array(
			'id' => array(
			    'type' => 'integer', 'null' => false, 'default' => null,
			    'length' => 10, 'key' => 'primary'
			),
			'locale' => array('type'=>'string', 'null' => false, 'length' => 6, 'key' => 'index'),
			'model' => array('type'=>'string', 'null' => false, 'key' => 'index'),
			'foreign_key' => array(
			    'type'=>'integer', 'null' => false, 'length' => 10, 'key' => 'index'
			),
			'field' => array('type'=>'string', 'null' => false, 'key' => 'index'),
			'content' => array('type'=>'text', 'null' => true, 'default' => null),
			'indexes' => array(
			    'PRIMARY' => array('column' => 'id', 'unique' => 1),
			    'locale' => array('column' => 'locale', 'unique' => 0),
			    'model' => array('column' => 'model', 'unique' => 0),
			    'row_id' => array('column' => 'foreign_key', 'unique' => 0),
			    'field' => array('column' => 'field', 'unique' => 0)
			)
		));

		$result = $this->db->createSchema($schema);
		$this->assertNoPattern('/^CREATE INDEX(.+);,$/', $result);
	}

/**
 * testCakeSchema method
 *
 * Test that schema generated postgresql queries are valid. ref #5696
 * Check that the create statement for a schema generated table is the same as the original sql
 *
 * @return void
 * @access public
 */
	function testCakeSchema() {
		$db1 =& ConnectionManager::getDataSource('test_suite');
		$db1->cacheSources = false;
		$db1->reconnect(array('persistent' => false));
		$db1->query('CREATE TABLE ' .  $db1->fullTableName('datatypes') . ' (
			id serial NOT NULL,
			"varchar" character varying(40) NOT NULL,
			"full_length" character varying NOT NULL,
			"timestamp" timestamp without time zone,
			date date,
			CONSTRAINT test_suite_data_types_pkey PRIMARY KEY (id)
		)');
		$model = new Model(array('name' => 'Datatype', 'ds' => 'test_suite'));
		$schema = new CakeSchema(array('connection' => 'test_suite'));
		$result = $schema->read(array(
			'connection' => 'test_suite',
			'models' => array('Datatype')
		));
		$schema->tables = array('datatypes' => $result['tables']['datatypes']);
		$result = $db1->createSchema($schema, 'datatypes');

		$this->assertNoPattern('/timestamp DEFAULT/', $result);
		$this->assertPattern('/\"full_length\"\s*text\s.*,/', $result);
		$this->assertPattern('/timestamp\s*,/', $result);

		$db1->query('DROP TABLE ' . $db1->fullTableName('datatypes'));

		$db1->query($result);
		$result2 = $schema->read(array(
			'connection' => 'test_suite',
			'models' => array('Datatype')
		));
		$schema->tables = array('datatypes' => $result2['tables']['datatypes']);
		$result2 = $db1->createSchema($schema, 'datatypes');
		$this->assertEqual($result, $result2);

		$db1->query('DROP TABLE ' . $db1->fullTableName('datatypes'));
	}

/**
 * Test index generation from table info.
 *
 * @return void
 */
	function testIndexGeneration() {
		$name = $this->db->fullTableName('index_test', false);
		$this->db->query('CREATE TABLE ' . $name . ' ("id" serial NOT NULL PRIMARY KEY, "bool" integer, "small_char" varchar(50), "description" varchar(40) )');
		$this->db->query('CREATE INDEX pointless_bool ON ' . $name . '("bool")');
		$this->db->query('CREATE UNIQUE INDEX char_index ON ' . $name . '("small_char")');
		$expected = array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'pointless_bool' => array('column' => 'bool', 'unique' => 0),
			'char_index' => array('column' => 'small_char', 'unique' => 1),

		);
		$result = $this->db->index($name);
		$this->assertEqual($expected, $result);

		$this->db->query('DROP TABLE ' . $name);
		$name = $this->db->fullTableName('index_test_2', false);
		$this->db->query('CREATE TABLE ' . $name . ' ("id" serial NOT NULL PRIMARY KEY, "bool" integer, "small_char" varchar(50), "description" varchar(40) )');
		$this->db->query('CREATE UNIQUE INDEX multi_col ON ' . $name . '("small_char", "bool")');
		$expected = array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'multi_col' => array('column' => array('small_char', 'bool'), 'unique' => 1),
		);
		$result = $this->db->index($name);
		$this->assertEqual($expected, $result);
		$this->db->query('DROP TABLE ' . $name);
	}

/**
 * Test the alterSchema capabilities of postgres
 *
 * @access public
 * @return void
 */
	function testAlterSchema() {
		$Old =& new CakeSchema(array(
			'connection' => 'test_suite',
			'name' => 'AlterPosts',
			'alter_posts' => array(
				'id' => array('type' => 'integer', 'key' => 'primary'),
				'author_id' => array('type' => 'integer', 'null' => false),
				'title' => array('type' => 'string', 'null' => true),
				'body' => array('type' => 'text'),
				'published' => array('type' => 'string', 'length' => 1, 'default' => 'N'),
				'created' => array('type' => 'datetime'),
				'updated' => array('type' => 'datetime'),
			)
		));
		$this->db->query($this->db->createSchema($Old));

		$New =& new CakeSchema(array(
			'connection' => 'test_suite',
			'name' => 'AlterPosts',
			'alter_posts' => array(
				'id' => array('type' => 'integer', 'key' => 'primary'),
				'author_id' => array('type' => 'integer', 'null' => true),
				'title' => array('type' => 'string', 'null' => false, 'default' => 'my title'),
				'body' => array('type' => 'string', 'length' => 500),
				'status' => array('type' => 'integer', 'length' => 3, 'default' => 1),
				'created' => array('type' => 'datetime'),
				'updated' => array('type' => 'datetime'),
			)
		));
		$this->db->query($this->db->alterSchema($New->compare($Old), 'alter_posts'));

		$model = new CakeTestModel(array('table' => 'alter_posts', 'ds' => 'test_suite'));
		$result = $model->schema();
		$this->assertTrue(isset($result['status']));
		$this->assertFalse(isset($result['published']));
		$this->assertEqual($result['body']['type'], 'string');
		$this->assertEqual($result['status']['default'], 1);
		$this->assertEqual($result['author_id']['null'], true);
		$this->assertEqual($result['title']['null'], false);

		$this->db->query($this->db->dropSchema($New));
	}

/**
 * Test the alter index capabilities of postgres
 *
 * @access public
 * @return void
 */
	function testAlterIndexes() {
		$this->db->cacheSources = false;

		$schema1 =& new CakeSchema(array(
			'name' => 'AlterTest1',
			'connection' => 'test_suite',
			'altertest' => array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => 0),
				'name' => array('type' => 'string', 'null' => false, 'length' => 50),
				'group1' => array('type' => 'integer', 'null' => true),
				'group2' => array('type' => 'integer', 'null' => true)
			)
		));
		$this->db->query($this->db->createSchema($schema1));

		$schema2 =& new CakeSchema(array(
			'name' => 'AlterTest2',
			'connection' => 'test_suite',
			'altertest' => array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => 0),
				'name' => array('type' => 'string', 'null' => false, 'length' => 50),
				'group1' => array('type' => 'integer', 'null' => true),
				'group2' => array('type' => 'integer', 'null' => true),
				'indexes' => array(
					'name_idx' => array('column' => 'name', 'unique' => 0),
					'group_idx' => array('column' => 'group1', 'unique' => 0),
					'compound_idx' => array('column' => array('group1', 'group2'), 'unique' => 0),
					'PRIMARY' => array('column' => 'id', 'unique' => 1)
				)
			)
		));
		$this->db->query($this->db->alterSchema($schema2->compare($schema1)));

		$indexes = $this->db->index('altertest');
		$this->assertEqual($schema2->tables['altertest']['indexes'], $indexes);

		// Change three indexes, delete one and add another one
		$schema3 =& new CakeSchema(array(
			'name' => 'AlterTest3',
			'connection' => 'test_suite',
			'altertest' => array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => 0),
				'name' => array('type' => 'string', 'null' => false, 'length' => 50),
				'group1' => array('type' => 'integer', 'null' => true),
				'group2' => array('type' => 'integer', 'null' => true),
				'indexes' => array(
					'name_idx' => array('column' => 'name', 'unique' => 1),
					'group_idx' => array('column' => 'group2', 'unique' => 0),
					'compound_idx' => array('column' => array('group2', 'group1'), 'unique' => 0),
					'another_idx' => array('column' => array('group1', 'name'), 'unique' => 0))
		)));

		$this->db->query($this->db->alterSchema($schema3->compare($schema2)));

		$indexes = $this->db->index('altertest');
		$this->assertEqual($schema3->tables['altertest']['indexes'], $indexes);

		// Compare us to ourself.
		$this->assertEqual($schema3->compare($schema3), array());

		// Drop the indexes
		$this->db->query($this->db->alterSchema($schema1->compare($schema3)));

		$indexes = $this->db->index('altertest');
		$this->assertEqual(array(), $indexes);

		$this->db->query($this->db->dropSchema($schema1));
	}

/*
 * Test it is possible to use virtual field with postgresql
 *
 * @access public
 * @return void
 */
	function testVirtualFields() {
		$this->loadFixtures('Article', 'Comment');
		$Article = new Article;
		$Article->virtualFields = array(
			'next_id' => 'Article.id + 1',
			'complex' => 'Article.title || Article.body',
			'functional' => 'COALESCE(User.user, Article.title)',
			'subquery' => 'SELECT count(*) FROM ' . $Article->Comment->table
		);
		$result = $Article->find('first');
		$this->assertEqual($result['Article']['next_id'], 2);
		$this->assertEqual($result['Article']['complex'], $result['Article']['title'] . $result['Article']['body']);
		$this->assertEqual($result['Article']['functional'], $result['Article']['title']);
		$this->assertEqual($result['Article']['subquery'], 6);
	}

/**
 * Tests additional order options for postgres
 *
 * @access public
 * @return void
 */
	function testOrderAdditionalParams() {
		$result = $this->db->order(array('title' => 'DESC NULLS FIRST', 'body' => 'DESC'));
		$expected = ' ORDER BY "title" DESC NULLS FIRST, "body" DESC';
		$this->assertEqual($result, $expected);
	}

/**
* Test it is possible to do a SELECT COUNT(DISTINCT Model.field) query in postgres and it gets correctly quoted
*/
	function testQuoteDistinctInFunction() {
		$this->loadFixtures('Article');
		$Article = new Article;
		$result = $this->db->fields($Article, null, array('COUNT(DISTINCT Article.id)'));
		$expected = array('COUNT(DISTINCT "Article"."id")');
		$this->assertEqual($result, $expected);

		$result = $this->db->fields($Article, null, array('COUNT(DISTINCT id)'));
		$expected = array('COUNT(DISTINCT "id")');
		$this->assertEqual($result, $expected);

		$result = $this->db->fields($Article, null, array('COUNT(DISTINCT FUNC(id))'));
		$expected = array('COUNT(DISTINCT FUNC("id"))');
		$this->assertEqual($result, $expected);
	}

/**
 * test that saveAll works even with conditions that lack a model name.
 *
 * @return void
 */
	function testUpdateAllWithNonQualifiedConditions() {
		$this->loadFixtures('Article');
		$Article =& new Article();
		$result = $Article->updateAll(array('title' => "'Awesome'"), array('title' => 'Third Article'));
		$this->assertTrue($result);

		$result = $Article->find('count', array(
			'conditions' => array('Article.title' => 'Awesome')
		));
		$this->assertEqual($result, 1, 'Article count is wrong or fixture has changed.');
	}

/**
 * test alterSchema on two tables.
 *
 * @return void
 */
	function testAlteringTwoTables() {
		$schema1 =& new CakeSchema(array(
			'name' => 'AlterTest1',
			'connection' => 'test_suite',
			'altertest' => array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => 0),
				'name' => array('type' => 'string', 'null' => false, 'length' => 50),
			),
			'other_table' => array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => 0),
				'name' => array('type' => 'string', 'null' => false, 'length' => 50),
			)
		));
		$schema2 =& new CakeSchema(array(
			'name' => 'AlterTest1',
			'connection' => 'test_suite',
			'altertest' => array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => 0),
				'field_two' => array('type' => 'string', 'null' => false, 'length' => 50),
			),
			'other_table' => array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => 0),
				'field_two' => array('type' => 'string', 'null' => false, 'length' => 50),
			)
		));
		$result = $this->db->alterSchema($schema2->compare($schema1));
		$this->assertEqual(2, substr_count($result, 'field_two'), 'Too many fields');
		$this->assertFalse(strpos(';ALTER', $result), 'Too many semi colons');
	}
}
