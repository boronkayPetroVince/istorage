<?php

namespace ContainerYxdZqE8;
include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'doctrine'.\DIRECTORY_SEPARATOR.'persistence'.\DIRECTORY_SEPARATOR.'lib'.\DIRECTORY_SEPARATOR.'Doctrine'.\DIRECTORY_SEPARATOR.'Persistence'.\DIRECTORY_SEPARATOR.'ObjectManager.php';
include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'doctrine'.\DIRECTORY_SEPARATOR.'orm'.\DIRECTORY_SEPARATOR.'lib'.\DIRECTORY_SEPARATOR.'Doctrine'.\DIRECTORY_SEPARATOR.'ORM'.\DIRECTORY_SEPARATOR.'EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'doctrine'.\DIRECTORY_SEPARATOR.'orm'.\DIRECTORY_SEPARATOR.'lib'.\DIRECTORY_SEPARATOR.'Doctrine'.\DIRECTORY_SEPARATOR.'ORM'.\DIRECTORY_SEPARATOR.'EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderf99d1 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerd75ea = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties17c78 = [
        
    ];

    public function getConnection()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getConnection', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getMetadataFactory', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getExpressionBuilder', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'beginTransaction', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getCache', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getCache();
    }

    public function transactional($func)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'transactional', array('func' => $func), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->transactional($func);
    }

    public function commit()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'commit', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->commit();
    }

    public function rollback()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'rollback', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getClassMetadata', array('className' => $className), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'createQuery', array('dql' => $dql), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'createNamedQuery', array('name' => $name), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'createQueryBuilder', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'flush', array('entity' => $entity), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'clear', array('entityName' => $entityName), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->clear($entityName);
    }

    public function close()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'close', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->close();
    }

    public function persist($entity)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'persist', array('entity' => $entity), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'remove', array('entity' => $entity), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'refresh', array('entity' => $entity), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'detach', array('entity' => $entity), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'merge', array('entity' => $entity), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getRepository', array('entityName' => $entityName), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'contains', array('entity' => $entity), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getEventManager', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getConfiguration', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'isOpen', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getUnitOfWork', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getProxyFactory', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'initializeObject', array('obj' => $obj), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'getFilters', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'isFiltersStateClean', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'hasFilters', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return $this->valueHolderf99d1->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializerd75ea = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolderf99d1) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderf99d1 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderf99d1->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, '__get', ['name' => $name], $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        if (isset(self::$publicProperties17c78[$name])) {
            return $this->valueHolderf99d1->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf99d1;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderf99d1;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf99d1;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderf99d1;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, '__isset', array('name' => $name), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf99d1;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderf99d1;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, '__unset', array('name' => $name), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf99d1;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderf99d1;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, '__clone', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        $this->valueHolderf99d1 = clone $this->valueHolderf99d1;
    }

    public function __sleep()
    {
        $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, '__sleep', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;

        return array('valueHolderf99d1');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerd75ea = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerd75ea;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerd75ea && ($this->initializerd75ea->__invoke($valueHolderf99d1, $this, 'initializeProxy', array(), $this->initializerd75ea) || 1) && $this->valueHolderf99d1 = $valueHolderf99d1;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderf99d1;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderf99d1;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
