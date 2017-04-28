pipeline {
  agent any
  stages {
    stage('Start docker') {
      steps {
        sh 'docker-compose up -d'
      }
    }
    stage('PHPUnit') {
      steps {
        sh './scripts/test.sh'
      }
    }
  }
}