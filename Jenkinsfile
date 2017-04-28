pipeline {
  agent any
  stages {
    stage('Start docker') {
      steps {
        sh 'sudo docker-compose up -d'
      }
    }
    stage('Composer Install') {
      steps {
        sh 'sudo docker-compose exec -T php composer install'
      }
    }
    stage('PHPUnit') {
      steps {
        sh 'sudo ./scripts/test.sh'
      }
    }
    stage('Deploy') {
      when {
        expression {
          currentBuild.result == null || currentBuild.result == 'SUCCESS' || currentBuild.result == 'UNSTABLE'
        }
      }
      steps {
          sh 'sudo docker-compose down'
      }
    }
  }
}
