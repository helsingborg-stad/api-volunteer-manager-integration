<?php

namespace APIVolunteerManagerIntegration\Helper\DIContainer;

use ReflectionClass;
use ReflectionNamedType;

class DIContainerFactory
{
    public static function create(): DIContainer
    {
        return new class implements DIContainer {
            private array $dependencies = [];

            /**
             * @return void
             */
            public function bind($name, $dependency)
            {
                if (is_array($name)) {
                    array_walk($name, fn($n) => $this->bind($n, $dependency));

                    return;
                }

                $this->dependencies[$name] = $dependency;
            }

            public function resolve($name)
            {
                return $this->dependencies[$name];
            }

            /**
             * @param  string  $class
             *
             * @return object
             */
            public function make($class)
            {
                $constructor    = (new ReflectionClass($class))->getConstructor();
                $resolvedParams = [];
                if ($constructor) {
                    $params = $constructor->getParameters();
                    foreach ($params as $param) {
                        if ($param->getType() instanceof ReflectionNamedType) {
                            $paramClass     = new ReflectionClass($param->getType()->getName());
                            $paramClassName = $paramClass->getName();
                            if ($this->dependencies[$paramClassName]) {
                                $resolvedParams[] = $this->resolve($paramClassName);
                            }
                        }
                    }
                }

                return (new ReflectionClass($class))->newInstanceArgs($resolvedParams);
            }
        };
    }
}